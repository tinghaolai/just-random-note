Deep Learning.ai
===
Regression: predict continuous value
Classification:discrete value

Square error function
> works fine for most regression problem

Gradient descent: Would have local optima
> convex for linear regression:only global optima

mean normalization(Didnt apply x0/bias) : $X_1 = \dfrac{X_1 - AVG_X1}{S_1}$

> avg : dat feature in whole training set
> S : Same as avg but range(max-min)

Make sure GD work correctly: converge ever iter
* hard to tell
* J keep goin up -> use smaller alpha
* choice for alpha : 1 0.1 0.01 0.001 (X3) (more specific in other class)

polynomial regression: feature scaling is important
Normal equation: $\theta=(X^TX)^-1X^Ty$
Comparition

| GD | NE 
| -------- | -------- 
| alpha needed| ~~alpha~~
| iter needed| ~~iter~~
| works well even n is large| but getting slow when n is large

---
Logistic Regression


$h_\theta(x) = g(\theta^Tx) \\ sigmoid:g(z)=\dfrac{1}{1+e^-z}$ 
![](https://i.imgur.com/59pXmuL.png)
>we cant have a cost function like Square error function->local optima
>
$Cost(h_\theta(x),y) =\left\{\begin{aligned}-log(h_\theta(x)\ if\ \  y\ =\ 1 \\-log(1-h_\theta(x))\ if\ \ y\ =\ 0\end{aligned}\right.$
$J(\theta) = -\dfrac 1 m[\displaystyle\sum_{i=1}^{m}y^(i)log\ h_\theta(x^i)+(1-y^i)log(1-h_\theta(x^i))]$

Overfitting
* reduce number of features
    * manually
    * Model selection algorithm
*   Regularization
    * not apply to x0/bias
    * 2 ez 2 put on , check if 1-3.png needed
---
### Why neural netework?
> Too many features in high poly

Cost function: similar to Logistic Regression
>check more on 4-6.png

Gradient checking: Numerical estimation of gradients
$\dfrac d {d\theta}J(\theta) \approx\dfrac{J(\theta+\varepsilon)-J(\theta-\varepsilon)}{2^\varepsilon} \ \ \varepsilon = 10^{-4}\ or\ something\ like\ this$

Important to random initialization:Symmetry breaking
> We'll get local-optima in NN becuz non-convex,but still works not bad
> if GD -> down hill then backprop -> finding direction to down hill

---
### Whick first?
* more data
* scaling feature
* poly feature
* tune lambda
Now we need cross validation to check ==Bias== or ==Variance== problem
>plot learning curve

Error analysis : manually check wrong example in CV 
to decide whether you fix some specific problem

Precision : accuracy of u guess
Recall : accuracy overall
F1 score: 2 * PR(P+R)
so...we'll have a trading off on this : Threshold - predict 1 if h(x) > 0.5/0.3

---

Large Margin Classification
===

## Support Vector Machine (Linear)
 > We want very confidence about the answers
 > using hyper parameter to control margin
 > cost function : similar to LR with regularization but $A+B*lambda->C*A+B$
 > $C = \dfrac 1 \lambda$
 > We can set C to be very large that force $cost_1\&cost_0$ to be small

Hypothsis: $h_\theta(x) =\left\{\begin{aligned}1\ if\ \  \theta^Tx\ge\ &=\ 0 \\0\ otherwise\end{aligned}\right.$


![](https://i.imgur.com/SGHbHdv.png)
![](https://i.imgur.com/6SVssXX.png)

 #### Kernel (Gaussion kernel)
 choose landmark to cal the simialrity
 Gaussion parameter:
 ![](https://i.imgur.com/UgjlmtB.png)

Predict "1" when $\theta_0 + \theta_1f_1 + \theta_ff_2 +\theta_3f_3 \ge 0$
>choosing landmatk : from examples

SVM with Kernels

```
Given x1,y1 ... ym,ym
choose l1 = x1  ... lm = xm
f1 = similarity(x,l1)
f2 = ...
f1^i = sim(x^i,l1)
f^i = [f0^i f1^i ... fm^i]
#Fetures get
predict then using cost function above to optimize
```
 > Using kernel to LR would be very slow
 Multi-class built-in finction or one-vs-all method
 
 When to use?
 * LR : n is large
 * SVM without kernel(linear) : n is large
 * SVM with Gaussian kernel : n is small m is intermediate
     * if m is large : add more features then us LR/SVM linear
* NN : slow but works fine most of time

---

#### Kmeans : randomly pick example to be clust-center and average
>Choosing K : elbow method

 　
### Dimensionality reduction (Data Compression)
* reduce load
* visiualize
* feature scaling
    * preprocessing : mean normalization 

#### PCA : principal component alaysis

![](https://i.imgur.com/xf9WjJ0.png)

compute covariance matrix
$\Sigma = \dfrac 1 m (x^{i})(x^i)^T$
compute eigenvectors of matrix above
$[U, S, V]= svd(Sigma) \\ Ureduce = U(:,1:k) \\ z = Ureduce'*x$
>choosing K:depend on variance retained
>PCA shouldnt use for preventing overfit

Why not supervise?
* pos/neg sive
* too many kind of anomaly
* havent seen before
* spam is more likely to be supervise problem

#### Anomaly detection
Gaussian(Normal)distribution: $P(X,\mu,\sigma^2)= \dfrac{1}{\sqrt{2\pi}}exp(-\dfrac{(x-^\mu)^2}{2\sigma^2})$

$P(X) = \displaystyle\prod_{j = 1}^nP(x_j;\mu_j;\sigma_j^2)$

---
#### Recommender Systems : learning features
Collaborative Filtering
```
Finding x1 let theta1*x1 aprrox 5
but also finding  theta1 let theta1*x1 approx 5
```

---
#### Batch GD  / Stochastice GD / Mini-batach GD
* checking converge
#### Online Learning
#### Map-reduce


spilt data to computers,and compute deritive separetly,then main one'll calculate whole thing.

---
Ceiling Analsis

![](https://i.imgur.com/PwqLANA.png)

Overall
![](https://i.imgur.com/XQk65Ca.png)


###### tags: `Machine Learning` 