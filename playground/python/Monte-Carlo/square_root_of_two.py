import numpy as np

N = 1000000
approximation = np.mean((np.random.rand(1, N) * 2) ** 2 <= 2)
square_root_2 = approximation * 2

print("Square root of 2: ", square_root_2)

approx_2 = square_root_2 ** 2

print("Approximation of 2: ", approx_2)

# 如果在 1 ~ 100 選任意數與數字 x 比較, x 比較大的記錄為 50%, 那麽 x 約等於 50 / 0.5(比例) * 100（基數） = 50
# 如果為 30%, 那麽 x 約等於 30 / 0.3(比例) * 100（基數) = 100

# 計算 根號2 >= 2 以内任選一個數的機率
# 0.7xxxx(比例) * 2(基數) = 1.4xxxx

# 這個計算式兩邊都做平方, 一樣去計算比例
# 就會變成上面的 code: np.mean((np.random.rand(1, N) * 2) ** 2 <= 2)

