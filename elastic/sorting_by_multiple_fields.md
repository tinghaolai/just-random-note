<!--HugoNoteFlag-->

---


## Sorting by multiple fields

If you want to sorting more than one fields at the same time, or even more complex logic, then my solution is writing painless script.

#### Multiple sorting query
```php
    private function convertSortingSource($type, $order, $fields)
    {
        switch ($type) {
            case 'multiFields-int':
                $source    = 'Long date;';
                $operation = 'date ' . (($order === 'desc') ? '<' : '>');

                break;
            case 'multiFields-date':
                $source   = 'JodaCompatibleZonedDateTime date;';
                $operation = 'date.' . (($order === 'desc') ? 'isBefore' : 'isAfter');
        }

        foreach ($fields as $field) {
            $source .= '
                    if (
                        (doc["'. $field .'"].size() != 0) &&
                        (
                            (date == null) ||
                            (' . $operation . '(doc["'. $field .'"].value))
                        )
                    ) {';
                        switch ($type) {
                            case 'multiFields':
                            case 'multiFields-int':
                                $source .= 'date = doc["'. $field .'"].value;';
                                break;
                            case 'priority':
                                $source .= 'return doc["'. $field .'"].value.toInstant().toEpochMilli() / 1000;';
                                break;
                            default:
                                return '';
                        }
          $source .= '}';
        }

        switch ($type) {
            case 'multiFields-int':
                $source .= 'return (date == null) ? 0 : date;';

                break;
            default:
                $defaultTime = ($order === 'asc') ? Carbon::now()->addYears(10)->timestamp : 0;
                $source .= 'return (date == null) ? ' . $defaultTime . ' : date.toInstant().toEpochMilli() / 1000;';
        }

        return $source;
    }
```

> Calculate sorting score by different type, and run in painless.

#### Main Search Function

```php
    public function search(
        $searchIndex,
        $conditions,
        $startPage = 0,
        $size = 200000,
        $sortBy = 'created_at',
        $order = 'asc',
        $sortFiledNotExists = false,
        $selectFields = null,
        $sortingCondition = []
    )
    {
        if (($sortFiledNotExists === true)) {
            $sortQuery = [
                '_script' => [
                    'type' => 'number',
                    'script' => [
                        'inline' => '(0 == doc["' . $sortBy . '"].size()) ? -1 : doc["' . $sortBy . '"].value;'
                    ],
                    'order' => $order
                ]
            ];
        } else if (
            (isset($sortingCondition['type'])) &&
            ($sortingCondition['type']) &&
            (isset($sortingCondition['fields'])) &&
            (count($sortingCondition['fields']) > 0)
        ) {
            $sortQuery = [
                '_script' => [
                    'type'   => 'number',
                    'order'  => $order,
                    'script' => [
                        'lang'   => 'painless',
                        'source' => $this->convertSortingSource(
                            $sortingCondition['type'],
                            $order,
                            $sortingCondition['fields']
                        ),
                    ],
                ]
            ];
        } else {
            $sortQuery = [
                [
                    '_score' => [
                        'order' => $order,
                    ]
                ],
                [
                    $sortBy => [
                        'order' => $order,
                        'missing' => '_last'
                    ],
                ]
            ];
        }

        $params = [
            'index' => $searchIndex,
            'body'  => [
                'track_total_hits' => true,
                'query' => [
                    'bool' => $conditions
                ],
                'sort' => $sortQuery,
            ],
            'from' => $startPage,
            'size' => $size
        ];

        if ($selectFields !== null) {
            $params['_source'] = $selectFields;
        }

        $response = $this->client->search($params);

        return $response['hits'];
    }
```

> There's also three types of sorting, filed not exist sorting, multi-field-sorting and normal sorting


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 按多個字段排序

如果你想同時排序多個字段，甚至更複雜的邏輯，那麼我的解決方案是編寫痛點脚本。

#### 多重排序查詢
```php
    private function convertSortingSource($type, $order, $fields)
    {
        switch ($type) {
            case 'multiFields-int':
                $source    = 'Long date;';
                $operation = 'date ' . (($order === 'desc') ? '<' : '>');

                break;
            case 'multiFields-date':
                $source   = 'JodaCompatibleZonedDateTime date;';
                $operation = 'date.' . (($order === 'desc') ? 'isBefore' : 'isAfter');
        }

        foreach ($fields as $field) {
            $source .= '
                    if (
                        (doc["'. $field .'"].size() != 0) &&
                        (
                            (date == null) ||
                            (' . $operation . '(doc["'. $field .'"].value))
                        )
                    ) {';
                        switch ($type) {
                            case 'multiFields':
                            case 'multiFields-int':
                                $source .= 'date = doc["'. $field .'"].value;';
                                break;
                            case 'priority':
                                $source .= 'return doc["'. $field .'"].value.toInstant().toEpochMilli() / 1000;';
                                break;
                            default:
                                return '';
                        }
          $source .= '}';
        }

        switch ($type) {
            case 'multiFields-int':
                $source .= 'return (date == null) ? 0 : date;';

                break;
            default:
                $defaultTime = ($order === 'asc') ? Carbon::now()->addYears(10)->timestamp : 0;
                $source .= 'return (date == null) ? ' . $defaultTime . ' : date.toInstant().toEpochMilli() / 1000;';
        }

        return $source;
    }
```

> 通過不同的類型計算排序分數，在痛點中運行。

#### 主要搜索函數

```php
    public function search(
        $searchIndex,
        $conditions,
        $startPage = 0,
        $size = 200000,
        $sortBy = 'created_at',
        $order = 'asc',
        $sortFiledNotExists = false,
        $selectFields = null,
        $sortingCondition = []
    )
    {
        if (($sortFiledNotExists === true)) {
            $sortQuery = [
                '_script' => [
                    'type' => 'number',
                    'script' => [
                        'inline' => '(0 == doc["' . $sortBy . '"].size()) ? -1 : doc["' . $sortBy . '"].value;'
                    ],
                    'order' => $order
                ]
            ];
        } else if (
            (isset($sortingCondition['type'])) &&
            ($sortingCondition['type']) &&
            (isset($sortingCondition['fields'])) &&
            (count($sortingCondition['fields']) > 0)
        ) {
            $sortQuery = [
                '_script' => [
                    'type'   => 'number',
                    'order'  => $order,
                    'script' => [
                        'lang'   => 'painless',
                        'source' => $this->convertSortingSource(
                            $sortingCondition['type'],
                            $order,
                            $sortingCondition['fields']
                        ),
                    ],
                ]
            ];
        } else {
            $sortQuery = [
                [
                    '_score' => [
                        'order' => $order,
                    ]
                ],
                [
                    $sortBy => [
                        'order' => $order,
                        'missing' => '_last'
                    ],
                ]
            ];
        }

        $params = [
            'index' => $searchIndex,
            'body'  => [
                'track_total_hits' => true,
                'query' => [
                    'bool' => $conditions
                ],
                'sort' => $sortQuery,
            ],
            'from' => $startPage,
            'size' => $size
        ];

        if ($selectFields !== null) {
            $params['_source'] = $selectFields;
        }

        $response = $this->client->search($params);

        return $response['hits'];
    }
```

> 還有三種排序類型，不存在字段排序，多字段排序和正常排序。