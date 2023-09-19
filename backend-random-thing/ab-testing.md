## Ab testing

Write a simple example from PHP.

**Wrong algorithm**

```php
    public function abWrong()
    {
        $rates = [
            'a' => 5,
            'b' => 70,
            'c' => 25,
        ];

        $totalrate = 100;
        $counts = [
            'a' => 0,
            'b' => 0,
            'c' => 0,
        ];

        $totalTestCase = 10000000;
        for ($i = 0; $i < $totalTestCase; $i++) {
            foreach ($rates as $key => $rate) {
                $rollNumber = mt_rand(1, $totalrate);
                if (
                    $key !== 'c' &&
                    $rollNumber > $rate
                ) {
                    continue;
                }

                $counts[$key]++;
                break;
            }
        }

        $countPercent = [];
        foreach ($counts as $key => $count) {
            $countPercent[$key] = $count / $totalTestCase;
        }

        dd($countPercent);
    }
```

You can print the result of `$countPercent` to see the percentage is wrong.

### Think 1.

If a and b both are 10 percentage and c is 80 percentage

the correct percentage to hit either a or b should be 20 percentage,

but in this algorithm, it calculate if it hit 10 percentage twice,

which the percentage will be (100 percentage - (not hit a and not hit b)) = 100 - 0.9 * 0.9 = 19.19 percentage.

### Think 2.

If percentage of a is 90, 

and both b and c are 5 percentage,

when a is not hit,

rate of b and c should be 50 percentage each,

instead of 5 percentage and 5 percentage.


**Correct algorithm**

```php
    public function abRight()
    {
        $rates = [
            'a' => 5,
            'b' => 70,
            'c' => 25,
        ];

        $totalrate = array_sum($rates);
        $counts = [
            'a' => 0,
            'b' => 0,
            'c' => 0,
        ];

        $totalTestCase = 10000000;
        for ($i = 0; $i < $totalTestCase; $i++) {
            $accumulatedWeight = 0;
            $rollNumber = mt_rand(1, $totalrate);
            foreach ($rates as $key => $rate) {
                $accumulatedWeight += $rate;
                if (
                    $rollNumber <= $accumulatedWeight
                ) {
                    $counts[$key]++;
                    break;
                }
            }
        }

        $countPercent = [];
        foreach ($counts as $key => $count) {
            $countPercent[$key] = $count / $totalTestCase * 100;
        }

        dd($counts, $countPercent);
    }
```