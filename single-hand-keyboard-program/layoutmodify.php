<?php

class LayoutModify
{
    public function run()
    {
        $classKeysNeendToBePlaced = [
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '0',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'up',
            'down',
            'left',
            'right',
            'enter',
            'space',
            'backspace',
            'esc',
            'tab',
            'caps',
            ',',
            '!',
            '&',
            '#',
            '[',
            ']',
            '{',
            '}',
            '`',
            '~',
            '$',
            '=',
            ';',
            '|',
            '\\',
            '^',
            '?',
            ':',
            '(',
            ')',
            '.',
            '*',
            '+',
            '_',
            '/',
            '‘',
            '',
            '<',
            '>',
            '',
            '',
            '',
        ];

        $this->line('start');
        $setting = array(
            'layer1' => array(
                array(
                    array('name' => '111', 'value' => ''),
                    array('name' => '112', 'value' => ''),
                    array('name' => '113', 'value' => ''),
                    array('name' => '114', 'value' => ''),
                    array('name' => '115', 'value' => ''),
                    array('name' => '116', 'value' => ''),
                ),
                array(
                    array('name' => '121', 'value' => ''),
                    array('name' => '122', 'value' => ''),
                    array('name' => '123', 'value' => ''),
                    array('name' => '124', 'value' => ''),
                    array('name' => '125', 'value' => ''),
                    array('name' => '126', 'value' => ''),
                ),
                array(
                    array('name' => '131', 'value' => ''),
                    array('name' => '132', 'value' => ''),
                    array('name' => '133', 'value' => ''),
                    array('name' => '134', 'value' => ''),
                    array('name' => '135', 'value' => ''),
                    array('name' => '136', 'value' => ''),
                ),
                array(
                    array('name' => '141', 'value' => ''),
                    array('name' => '142', 'value' => ''),
                    array('name' => '143', 'value' => ''),
                    array('name' => '144', 'value' => ''),
                    array('name' => '145', 'value' => ''),
                    array('name' => '146', 'value' => ''),
                ),
                array(
                    array('name' => '151', 'value' => ''),
                    array('name' => '152', 'value' => ''),
                    array('name' => '153', 'value' => ''),
                    array('name' => '154', 'value' => ''),
                    array('name' => '155', 'value' => ''),
                    array('name' => '', 'value' => ''),
                ),
            ),

            'layer2' => array(
                array(
                    array('name' => '211', 'value' => ''),
                    array('name' => '212', 'value' => ''),
                    array('name' => '213', 'value' => ''),
                    array('name' => '214', 'value' => ''),
                    array('name' => '215', 'value' => ''),
                    array('name' => '216', 'value' => ''),
                ),
                array(
                    array('name' => '221', 'value' => ''),
                    array('name' => '222', 'value' => ''),
                    array('name' => '223', 'value' => ''),
                    array('name' => '224', 'value' => ''),
                    array('name' => '225', 'value' => ''),
                    array('name' => '226', 'value' => ''),
                ),
                array(
                    array('name' => '231', 'value' => ''),
                    array('name' => '232', 'value' => ''),
                    array('name' => '233', 'value' => ''),
                    array('name' => '234', 'value' => ''),
                    array('name' => '235', 'value' => ''),
                    array('name' => '236', 'value' => ''),
                ),
                array(
                    array('name' => '241', 'value' => ''),
                    array('name' => '242', 'value' => ''),
                    array('name' => '243', 'value' => ''),
                    array('name' => '244', 'value' => ''),
                    array('name' => '245', 'value' => ''),
                    array('name' => '246', 'value' => ''),
                ),
                array(
                    array('name' => '251', 'value' => ''),
                    array('name' => '252', 'value' => ''),
                    array('name' => '253', 'value' => ''),
                    array('name' => '254', 'value' => ''),
                    array('name' => '255', 'value' => ''),
                    array('name' => '', 'value' => ''),
                ),
            ),

            'layer3' => array(
                array(
                    array('name' => '311', 'value' => ''),
                    array('name' => '312', 'value' => ''),
                    array('name' => '313', 'value' => ''),
                    array('name' => '314', 'value' => ''),
                    array('name' => '315', 'value' => ''),
                    array('name' => '316', 'value' => ''),
                ),
                array(
                    array('name' => '321', 'value' => ''),
                    array('name' => '322', 'value' => ''),
                    array('name' => '323', 'value' => ''),
                    array('name' => '324', 'value' => ''),
                    array('name' => '325', 'value' => ''),
                    array('name' => '326', 'value' => ''),
                ),
                array(
                    array('name' => '331', 'value' => ''),
                    array('name' => '332', 'value' => ''),
                    array('name' => '333', 'value' => ''),
                    array('name' => '334', 'value' => ''),
                    array('name' => '335', 'value' => ''),
                    array('name' => '336', 'value' => ''),
                ),
                array(
                    array('name' => '341', 'value' => ''),
                    array('name' => '342', 'value' => ''),
                    array('name' => '343', 'value' => ''),
                    array('name' => '344', 'value' => ''),
                    array('name' => '345', 'value' => ''),
                    array('name' => '346', 'value' => ''),
                ),
                array(
                    array('name' => '351', 'value' => ''),
                    array('name' => '352', 'value' => ''),
                    array('name' => '353', 'value' => ''),
                    array('name' => '354', 'value' => ''),
                    array('name' => '355', 'value' => ''),
                    array('name' => '', 'value' => ''),
                ),
            ),

            'layer4' => array(
                array(
                    array('name' => '411', 'value' => ''),
                    array('name' => '412', 'value' => ''),
                    array('name' => '413', 'value' => ''),
                    array('name' => '414', 'value' => ''),
                    array('name' => '415', 'value' => ''),
                    array('name' => '416', 'value' => ''),
                ),
                array(
                    array('name' => '421', 'value' => ''),
                    array('name' => '422', 'value' => ''),
                    array('name' => '423', 'value' => ''),
                    array('name' => '424', 'value' => ''),
                    array('name' => '425', 'value' => ''),
                    array('name' => '426', 'value' => ''),
                ),
                array(
                    array('name' => '431', 'value' => ''),
                    array('name' => '432', 'value' => ''),
                    array('name' => '433', 'value' => ''),
                    array('name' => '434', 'value' => ''),
                    array('name' => '435', 'value' => ''),
                    array('name' => '436', 'value' => ''),
                ),
                array(
                    array('name' => '441', 'value' => ''),
                    array('name' => '442', 'value' => ''),
                    array('name' => '443', 'value' => ''),
                    array('name' => '444', 'value' => ''),
                    array('name' => '445', 'value' => ''),
                    array('name' => '446', 'value' => ''),
                ),
                array(
                    array('name' => '451', 'value' => ''),
                    array('name' => '452', 'value' => ''),
                    array('name' => '453', 'value' => ''),
                    array('name' => '454', 'value' => ''),
                    array('name' => '455', 'value' => ''),
                    array('name' => '', 'value' => ''),
                ),
            ),

            'layer5' => array(
                array(
                    array('name' => '511', 'value' => ''),
                    array('name' => '512', 'value' => ''),
                    array('name' => '513', 'value' => ''),
                    array('name' => '514', 'value' => ''),
                    array('name' => '515', 'value' => ''),
                    array('name' => '516', 'value' => ''),
                ),
                array(
                    array('name' => '521', 'value' => ''),
                    array('name' => '522', 'value' => ''),
                    array('name' => '523', 'value' => ''),
                    array('name' => '524', 'value' => ''),
                    array('name' => '525', 'value' => ''),
                    array('name' => '526', 'value' => ''),
                ),
                array(
                    array('name' => '531', 'value' => ''),
                    array('name' => '532', 'value' => ''),
                    array('name' => '533', 'value' => ''),
                    array('name' => '534', 'value' => ''),
                    array('name' => '535', 'value' => ''),
                    array('name' => '536', 'value' => ''),
                ),
                array(
                    array('name' => '541', 'value' => ''),
                    array('name' => '542', 'value' => ''),
                    array('name' => '543', 'value' => ''),
                    array('name' => '544', 'value' => ''),
                    array('name' => '545', 'value' => ''),
                    array('name' => '546', 'value' => ''),
                ),
                array(
                    array('name' => '551', 'value' => ''),
                    array('name' => '552', 'value' => ''),
                    array('name' => '553', 'value' => ''),
                    array('name' => '554', 'value' => ''),
                    array('name' => '555', 'value' => ''),
                    array('name' => '', 'value' => ''),
                ),
            ),
        );

        $cellWidth = 10;
//        $this->printSettingStraight($setting, $cellWidth);
        $this->printSettingCrossed($setting, $cellWidth);
    }

    public function printSettingCrossed($setting, $cellWidth)
    {
        $layers = array_keys($setting);

        $headerWidth = $cellWidth + 2;
        foreach ($layers as $key => $layerName) {
            $BLUE = "\033[96m"; // 淡藍色
            $RESET = "\033[0m";  // 重置顏色

            if ($key === 0) {
                echo $BLUE
                    . str_pad('=== ' . strtoupper($layerName) . ' ===', $headerWidth * 5, ' ', STR_PAD_BOTH)
                    . $RESET;
            } else {
                echo $BLUE
                    . str_pad('=== ' . strtoupper($layerName) . ' ===', $headerWidth * 6, ' ', STR_PAD_BOTH)
                    . $RESET;
            }
        }
        echo PHP_EOL . PHP_EOL;

        // 以 layer1 的 row 數為基準
        $rowCount = count($setting[$layers[0]]);

        for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
            /* ---------- 第一行：name ---------- */
            foreach ($layers as $layerName) {
                foreach ($setting[$layerName][$rowIndex] as $key) {
                    $KEY_NAME = "\033[95m";
                    $RESET = "\033[0m";

                    echo $KEY_NAME
                        . str_pad($key['name'], $cellWidth, ' ', STR_PAD_BOTH)
                        . $RESET;
                }
                echo str_pad('', $cellWidth, ' '); // layer 間距
            }
            echo PHP_EOL;

            /* ---------- 第二行：value ---------- */
            foreach ($layers as $layerName) {
                foreach ($setting[$layerName][$rowIndex] as $key) {
                    echo str_pad($key['value'], $cellWidth, ' ', STR_PAD_BOTH);
                }
                echo str_pad('', $cellWidth, ' ');
            }
            echo PHP_EOL . PHP_EOL;
        }
    }

    public function printSettingStraight($setting, $cellWidth)
    {
        foreach ($setting as $layerName => $layerRows) {
            echo "=== " . strtoupper($layerName) . " ===" . PHP_EOL . PHP_EOL;

            foreach ($layerRows as $row) {
                // 第一行：name
                foreach ($row as $key) {
                    echo str_pad($key['name'], $cellWidth, ' ', STR_PAD_BOTH);
                }
                echo PHP_EOL;

                // 第二行：value（在 name 正下方）
                foreach ($row as $key) {
                    echo str_pad($key['value'], $cellWidth, ' ', STR_PAD_BOTH);
                }
                echo PHP_EOL . PHP_EOL;
            }

            echo PHP_EOL;
        }
    }

    public function line($message)
    {
        echo $message . PHP_EOL;
    }
}

$main = new LayoutModify();
$main->run();