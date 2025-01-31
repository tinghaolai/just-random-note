import subprocess
import re
from datetime import datetime, timedelta
from itertools import product
import json

timerange = '1738330407-1738341207'

def transform_loop_setting(setting):
    return [
        {"strategy_base": setting["strategy_base"], "strategy": setting["strategy"], "config": setting["config"], "aiModel": value}
        for value in setting["aiModels"]
    ]

runSettings = [
    *transform_loop_setting({
        "strategy_base": "NOTankAi_15_backtest_base",
        "strategy": "NOTankAi_15_backtest_final",
        "config": "_config/config_ai_backtest",
        "aiModels": ["LightGBMRegressor"]
    })
]

def transform_loop_setting(data):
    return [
        {"name": data["name"], "placeholder": data["placeholder"], "placeValue": value}
        for value in data["placeValues"]
    ]

canShorts = transform_loop_setting({
    "name": "canShort",
    "placeholder": '"__canShortPlaceHolder"',
    "placeValues": ["True", "False"]
})

stopLosses = transform_loop_setting({
    "name": "stopLoss",
    "placeholder": '"__stopLossPlaceHolder"',
    "placeValues": ["-0.2"]
})

timeFrames = transform_loop_setting({
    "name": "timeFrame",
    "placeholder": '__timeFramePlaceHolder',
    "placeValues": ["15"]
})

data = []

for runSetting in runSettings:
    strategy = runSetting['strategy']
    config = runSetting['config']
    strategy_base = runSetting['strategy_base']
    result = command = f"rm user_data/strategies/{strategy}.py && cp user_data/strategies/{strategy_base}.py user_data/strategies/{strategy}.py"
    subprocess.run(command, shell=True, capture_output=True, text=True)
    command =f"sed -i '' 's/{strategy_base}/{strategy}/g' user_data/strategies/{strategy}.py"
    subprocess.run(command, shell=True, capture_output=True, text=True)

    print(f"Running command: {command}")

    for canShort, stopLoss in product(canShorts, stopLosses):
        modifyFinals = [canShort, stopLoss]
        modifyFinalName = ""
        for modifySetting in modifyFinals:
            modifyFinalName += modifySetting["name"] + ":" + modifySetting["placeValue"] + "/"
            command = f"sed -i '' 's/{modifySetting['placeholder']}/{modifySetting['placeValue']}/g' user_data/strategies/{strategy}.py"
            print(f"Running command: {command}")
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
            coin = match[0]
            profit = float(match[1])
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
    print(d['coin'], d['strategy'], d['aiModel'] ,d['profit'])
