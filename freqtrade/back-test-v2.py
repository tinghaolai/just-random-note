import subprocess
import re
from datetime import datetime, timedelta
from itertools import product
import json

# -----settings------
timerange = '1738330407-1738341207'
aiModelsSettings = ["LightGBMRegressor"]
canShortsSettings = ["True", "False"]
stopLossesSettings = ["-0.2"]
timeFramesSettings = ["15"]
minROIsSettings = [
    '{ "0": 0.5, "60": 0.45, "120": 0.4, "240": 0.3, "360": 0.25, "720": 0.2, "1440": 0.15, "2880": 0.1, "3600": 0.05, "7200": 0.02, }'
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

# -----settings end------
def transform_loop_setting(setting):
    return [
        {"strategy_base": setting["strategy_base"], "strategy": setting["strategy"], "config": setting["config"],
         "aiModel": value, "config_base": setting["config_base"]}
        for value in setting["aiModels"]
    ]


runSettings = [
    *transform_loop_setting({
        "strategy_base": "NOTankAi_15_backtest_base",
        "strategy": "NOTankAi_15_backtest_final",
        "config_base": "_config/config_ai_backtest_base",
        "config": "_config/config_ai_backtest_final",
        "aiModels": aiModelsSettings
    })
]


def format_setting_value(value):
    if isinstance(value, str):
        return value.replace("/", r"\/")
    return value


def transform_loop_setting(data):
    return [
        {"name": data["name"], "placeholder": data["placeholder"], "placeValue": format_setting_value(value)}
        for value in data["placeValues"]
    ]


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

for runSetting in runSettings:
    strategy = runSetting['strategy']
    config = runSetting['config']
    strategy_base = runSetting['strategy_base']

    command = f"rm user_data/strategies/{strategy}.py && cp user_data/strategies/{strategy_base}.py user_data/strategies/{strategy}.py"
    subprocess.run(command, shell=True, capture_output=True, text=True)
    command = f"sed -i '' 's/{strategy_base}/{strategy}/g' user_data/strategies/{strategy}.py"
    subprocess.run(command, shell=True, capture_output=True, text=True)

    command = f"rm user_data/{config}.json && cp user_data/{runSetting['config_base']}.json user_data/{config}.json"
    subprocess.run(command, shell=True, capture_output=True, text=True)

    for canShort, stopLoss, timeFrame, minROI, featureParameterTimeFrame, featureParameterPairList, featureParameterCandle, featureParameterShiftCandle, featureParameterDI, featureParameterWeightFactor, featureParameterIndicatorCandle in product(
            canShorts,
            stopLosses,
            timeFrames,
            minROIs,
            featureParameterTimeFrames,
            featureParameterPairLists, featureParameterCandles, featureParameterShiftCandles, featureParameterDIs,
            featureParameterWeightFactors, featureParameterIndicatorCandles):
        modifyFinals = [canShort, stopLoss, timeFrame, minROI]
        modifyFinalName = ""
        for modifySetting in modifyFinals:
            modifyFinalName += modifySetting["name"] + ":" + modifySetting["placeValue"] + "/"
            command = f"sed -i '' 's/{modifySetting['placeholder']}/{modifySetting['placeValue']}/g' user_data/strategies/{strategy}.py"
            subprocess.run(command, shell=True, capture_output=True, text=True)

        modifyConfigFinals = [featureParameterTimeFrame, featureParameterPairList, featureParameterCandle,
                              featureParameterShiftCandle, featureParameterDI, featureParameterWeightFactor,
                              featureParameterIndicatorCandle]
        for modifySetting in modifyConfigFinals:
            modifyFinalName += modifySetting["name"] + ":" + modifySetting["placeValue"] + "/"
            command = f"sed -i '' 's/{modifySetting['placeholder']}/{modifySetting['placeValue']}/g' user_data/{config}.json"
            print(command)
            subprocess.run(command, shell=True, capture_output=True, text=True)

        aiModel = runSetting['aiModel']
        # command = f"freqtrade backtesting --config user_data/{config}.json  --strategy {strategy} "
        command = f"freqtrade backtesting --config user_data/{config}.json  --strategy {strategy} --timerange='{timerange}' --fee 0.0005 --freqaimodel {aiModel}"

        print(f"Running command: {command}")
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
        for match in matches:
            coin = match[0]  # 交易對名稱或 "TOTAL"
            profit = float(match[1])  # 獲取 Tot Profit (USDT)
            data.append({
                "coin": coin,
                "profit": profit,
                "strategy": strategy + "/" + modifyFinalName,
                "aiModel": aiModel
            })

# sorted_data = sorted(data, key=lambda x: x['profit'], reverse=True)
sorted_data = sorted(data, key=lambda x: x['profit'], reverse=False)

print("---------")
print("---------")
print("---------")
# print(data)
print('coin', 'strategy', 'aiModel', 'profit')
for d in sorted_data:
    print(f"\033[96m{d['coin']}\033[0m", d['strategy'], d['aiModel'], f"\033[91m{d['profit']}\033[0m")
