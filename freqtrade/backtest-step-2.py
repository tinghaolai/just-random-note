import subprocess
import re
from datetime import datetime, timedelta
from itertools import product
import json
import sys
import os
import time

start = time.time()

# -----settings------
# timerange = '1738335426-1738378626'
# timerange = '1737982767-1739710767'
# timerange = '1749359740-1749446140'
# timerange = '1749606958-1749628558'
timerange = '1750625387-1750654187'
sliceMinute = 60

start_ts, end_ts = map(int, timerange.split('-'))
slice_seconds = sliceMinute * 60
timeranges = []
current_start = start_ts
while current_start < end_ts:
    current_end = min(current_start + slice_seconds, end_ts)
    timeranges.append(f"{current_start}-{current_end}")
    current_start = current_end

date_str = datetime.now().strftime('%Y%m%d')
directory = '_records'
os.makedirs(directory, exist_ok=True)
resultFilename = f'{directory}/{date_str}.txt'
print(f"Result will be saved to: {resultFilename}")

for sliced_timerange in timeranges:
    print(f"Running backtest for timerange: {sliced_timerange}")
# sys.exit(0)

realProfitPercentages = [30]

aiModelsSettings = ["LightGBMRegressor"]

canShortsSettings = ["True"]
# stopLossesSettings = ["-0.02"]
stopLossesSettings = ["-0.004"]
# stopLossesSettings = ["-0.005"]
# timeFramesSettings = ["15m"]
timeFramesSettings = ["3m"]
minROIsSettings = [
    '{ "0": 0.5, "60": 0.45, "120": 0.4, "240": 0.3, "360": 0.25, "720": 0.2, "1440": 0.15, "2880": 0.1, "3600": 0.05, "7200": 0.02, }',
]

hasAIModelSettings = [
    # "true",
    "false"
]


featureParameterTimeFramesSettings = [
    '["3m","15m","1h"]'
]

featureParameterPairListsSettings = [
    '["BTC/USDT:USDT","ETH/USDT:USDT"]'
]

featureParameterCandlesSettings = [
    '20'
]

featureParameterShiftCandlesSettings = [
    '2'
]

featureParameterDIsSettings = [
    '0.9'
]

featureParameterWeightFactorsSettings = [
    '0.9'
]

featureParameterIndicatorCandlesSettings = [
    '[10,20]'
]

basePairs = [
    "PROM/USDT:USDT",
    "SCR/USDT:USDT",
]

pair_args = " ".join(basePairs)


# -----settings end------
def transform_run_setting(setting):
    return [
        {"strategy_base": setting["strategy_base"], "strategy": setting["strategy"], "config": setting["config"],
         "aiModel": value, "config_base": setting["config_base"]}
        for value in setting["aiModels"]
    ]

runSettings = [
    # no diff for settings, 1749145289-1749231689 total profit： 3200.703
    *transform_run_setting({
        "strategy_base": "NOTankAi_15_backtest_base_v2",
        "strategy": "NOTankAi_15_backtest_final_v2",
        "config_base": "_config/config_ai_backtest_base_v3_ai",
        "config": "_config/config_ai_backtest_final_v3",
        "aiModels": aiModelsSettings
    }),
]



def format_setting_value(value):
    if isinstance(value, str):
        return value.replace("/", r"\/")
    return value

def log(array, message=None):
    date_str = datetime.now().strftime('%Y%m%d')
    directory = '_logs'
    os.makedirs(directory, exist_ok=True)
    logname = f'{directory}/log-{date_str}.txt'
    with open(logname, 'a', encoding='utf-8') as f:
        if message:
            f.write(f"{message}\n")
        f.write(json.dumps(array, ensure_ascii=False) + '\n')

def transform_loop_setting(data):
    return [
        {"name": data["name"], "placeholder": data["placeholder"], "placeValue": format_setting_value(value)}
        for value in data["placeValues"]
    ]

hasAIModels = transform_loop_setting({
    "name": "hasAIModel",
    "placeholder": '"__hasAIModelPlaceHolder"',
    "placeValues": hasAIModelSettings
})

canShorts = transform_loop_setting({
    "name": "canShort",
    "placeholder": '"__canShortPlaceHolder"',
    "placeValues": canShortsSettings
})

stopLosses = transform_loop_setting({
    "name": "stopLoss",
    "placeholder": '"__stopLossPlaceHolder"',
    "placeValues": stopLossesSettings
})

timeFrames = transform_loop_setting({
    "name": "timeFrame",
    "placeholder": '__timeFramePlaceHolder',
    "placeValues": timeFramesSettings
})

minROIs = transform_loop_setting({
    "name": "minROI",
    "placeholder": '"__minROIPlaceHolder"',
    "placeValues": minROIsSettings
})

featureParameterTimeFrames = transform_loop_setting({
    "name": "fpTimeFrame",
    "placeholder": '"__featureParameterTimeFramePlaceHolder"',
    "placeValues": featureParameterTimeFramesSettings
})

featureParameterPairLists = transform_loop_setting({
    "name": "fpPairList",
    "placeholder": '"__featureParameterPairListPlaceHolder"',
    "placeValues": featureParameterPairListsSettings
})

featureParameterCandles = transform_loop_setting({
    "name": "fpCandles",
    "placeholder": '"__featureParameterCandlesPlaceHolder"',
    "placeValues": featureParameterCandlesSettings})

featureParameterShiftCandles = transform_loop_setting({
    "name": "fpShiftCandles",
    "placeholder": '"__featureParameterShiftCandlesPlaceHolder"',
    "placeValues": featureParameterShiftCandlesSettings})

featureParameterDIs = transform_loop_setting({
    "name": "fpDIs",
    "placeholder": '"__featureParameterDIsPlaceHolder"',
    "placeValues": featureParameterDIsSettings
})

featureParameterWeightFactors = transform_loop_setting({
    "name": "fpWeightFactors",
    "placeholder": '"__featureParameterWeightFactorsPlaceHolder"',
    "placeValues": featureParameterWeightFactorsSettings})

featureParameterIndicatorCandles = transform_loop_setting({
    "name": "fpIndicatorCandles",
    "placeholder": '"__featureParameterIndicatorCandlesPlaceHolder"',
    "placeValues": featureParameterIndicatorCandlesSettings})

data = []
sliceTotal = []

for runSetting in runSettings:
    strategy = runSetting['strategy']
    config = runSetting['config']
    strategy_base = runSetting['strategy_base']

    command = f"rm user_data/strategies/{strategy}.py && cp user_data/strategies/{strategy_base}.py user_data/strategies/{strategy}.py"
    subprocess.run(command, shell=True, capture_output=True, text=True)
    # linux
    # command = f"sed -i 's/{strategy_base}/{strategy}/g' user_data/strategies/{strategy}.py"
    # mac
    command = f"sed -i '' 's/{strategy_base}/{strategy}/g' user_data/strategies/{strategy}.py"
    print('----sed----')
    print(command)
    subprocess.run(command, shell=True, capture_output=True, text=True)

    command = f"rm user_data/{config}.json && cp user_data/{runSetting['config_base']}.json user_data/{config}.json"
    subprocess.run(command, shell=True, capture_output=True, text=True)

    for canShort, stopLoss, timeFrame, minROI, featureParameterTimeFrame, featureParameterPairList, featureParameterCandle, featureParameterShiftCandle, featureParameterDI, featureParameterWeightFactor, featureParameterIndicatorCandle, hasAIModel in product(
            canShorts,
            stopLosses,
            timeFrames,
            minROIs,
            featureParameterTimeFrames,
            featureParameterPairLists, featureParameterCandles, featureParameterShiftCandles, featureParameterDIs,
            featureParameterWeightFactors, featureParameterIndicatorCandles, hasAIModels):
        modifyFinals = [canShort, stopLoss, timeFrame, minROI]
        modifyFinalName = ""
        for modifySetting in modifyFinals:
            modifyFinalName += modifySetting["name"] + ":" + modifySetting["placeValue"] + "/"
            command = f"sed -i '' 's/{modifySetting['placeholder']}/{modifySetting['placeValue']}/g' user_data/strategies/{strategy}.py"
            subprocess.run(command, shell=True, capture_output=True, text=True)

        modifyConfigFinals = [featureParameterTimeFrame, featureParameterPairList, featureParameterCandle,
                              featureParameterShiftCandle, featureParameterDI, featureParameterWeightFactor,
                              featureParameterIndicatorCandle, hasAIModel]
        for modifySetting in modifyConfigFinals:
            modifyFinalName += modifySetting["name"] + ":" + modifySetting["placeValue"] + "/"
            command = f"sed -i '' 's/{modifySetting['placeholder']}/{modifySetting['placeValue']}/g' user_data/{config}.json"
            subprocess.run(command, shell=True, capture_output=True, text=True)

        aiModel = runSetting['aiModel']
        # command = f"freqtrade backtesting --config user_data/{config}.json  --strategy {strategy} "


        for realProfitPercentage in realProfitPercentages:
            slicedTraceCount = 0
            currentSliceData = []
            currentSliceProfitTotal = 0
            nextPickRealTradePairs = []
            for sliced_timerange in timeranges:
                slicedTraceCount += 1
                # command = f"freqtrade backtesting --config user_data/{config}.json  --strategy {strategy} --timerange='{sliced_timerange}' --fee 0.0005 --freqaimodel {aiModel}"
                # command = f"freqtrade backtesting --config user_data/{config}.json --strategy {strategy} --timerange='{sliced_timerange}' --fee 0.0005 --freqaimodel {aiModel} --pairs {pair_args}"
                command = f"freqtrade backtesting --config user_data/{config}.json --strategy {strategy} --timerange='{sliced_timerange}' --fee 0.0005"
                if hasAIModel["placeValue"] == "true":
                    command += f" --freqaimodel {aiModel}"

                print(command)
                result = subprocess.run(command, shell=True, capture_output=True, text=True)

                # print(result.stdout)
                if result.stderr:
                    print(f"Error: {result.stderr}")
                # findReportMatch = r"BACKTESTING REPORT.*?┡━━━━━━━━━━━━╇━━━━━━━━╇━━━━━━━━━━━━╇━━━━━━━━━━━━╇━━━━━━━━━━━━╇━━━━━━━━━━━━╇━━━━━━━━━━━━━┩(.*?)LEFT OPEN TRADES REPORT"
                findReportMatch = r"BACKTESTING REPORT.*LEFT OPEN TRADES REPORT"
                reportMatches = re.findall(findReportMatch, result.stdout, re.DOTALL)

                # print(result.stdout)
                print(reportMatches[0])
                pattern = r"│\s*(\S+/\S+|\S+)\s*│\s*\d+\s*│\s*\d+\.\d+\s*│\s*([\d\.\-]+)\s*│"
                matches = re.findall(pattern, reportMatches[0])
                currentMatches = []
                for match in matches:
                    coin = match[0]  # 交易對名稱或 "TOTAL"
                    profit = float(match[1])  # 獲取 Tot Profit (USDT)
                    data.append({
                        "coin": coin,
                        "profit": profit,
                        "strategy": strategy + "/" + modifyFinalName,
                        "aiModel": aiModel,
                        "sliced_timerange": sliced_timerange,
                        "slicedTraceCount": slicedTraceCount
                    })
                    # currentSliceProfitTotal += profit
                    if coin != "TOTAL" and coin in nextPickRealTradePairs:
                        currentSliceProfitTotal += profit
                        log(profit, "add profit")

                    if coin != "TOTAL":
                        currentMatches.append({
                            "coin": coin,
                            "profit": profit,
                        })

                #     sort currentMatches by profit in descending order and get nextPickRealTradePairs by realProfitPercentages
                # nextPickRealTradePairs = pick top % by realProfitPercentage
                currentMatches.sort(key=lambda x: x['profit'], reverse=True)
                nextPickRealTradePairs = []
                for i in range(int(len(currentMatches) * (realProfitPercentage / 100))):
                    if i < len(currentMatches):
                        nextPickRealTradePairs.append(currentMatches[i]['coin'])
                log(nextPickRealTradePairs, "nextPickRealTradePairs")
                print(f"nextPickRealTradePairs: {nextPickRealTradePairs}, realProfitPercentage: {realProfitPercentage}")

            sliceTotal.append({
                "profitTotal": currentSliceProfitTotal,
                "timerange": timerange,
                "realProfitPercentage": realProfitPercentage,
                "sliceMinute": sliceMinute,
            })

        # with open(resultFilename, 'a', encoding='utf-8') as f:
        #     f.write(json.dumps(currentSliceData, ensure_ascii=False) + '\n')

# sorted_data = sorted(data, key=lambda x: x['profit'], reverse=True)
sorted_data = sorted(data, key=lambda x: x['profit'], reverse=False)

print("---------")
print("---------")
print("---------")
# print(data)
print('coin', 'strategy', 'aiModel', 'profit')
for d in sorted_data:
    print(f"\033[96m{d['coin']}\033[0m", d['strategy'], d['aiModel'], f"\033[91m{d['profit']}\033[0m", d['sliced_timerange'], d['slicedTraceCount'])
#
# with open(resultFilename, 'a', encoding='utf-8') as f:
#     f.write(json.dumps(data, ensure_ascii=False) + '\n')

with open(resultFilename, 'a', encoding='utf-8') as f:
    f.write(json.dumps(sliceTotal, ensure_ascii=False) + '\n')

end = time.time()
elapsed_minutes = (end - start) / 60
elapsed_seconds = (end - start)
print(f"花費時間：約 {elapsed_minutes:.2f} 分鐘")
print(f"花費時間：約 {elapsed_seconds:.2f} 秒")
