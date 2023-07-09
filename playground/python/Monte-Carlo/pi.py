from random import random

count = 10000000
hits = 0
for i in range(count):
    x, y = random(), random()
    if x * x + y * y < 1:
        hits += 1
print("PI: ", 4 * hits / count)

# 用畢氏定理去看隨機點與原點(0,0)的距離是否超過半徑(1)
