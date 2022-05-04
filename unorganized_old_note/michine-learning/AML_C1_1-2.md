AML-C1-Week 1-2 :Advanced Machine Learning - Couse 1 Introduction to Deep learning(week 1 -2)
===

### Week 1
regrssion task: real number
classification task


MSE Mean squared error:  $\begin{split} L(w) &= \dfrac{1}{l} \displaystyle\sum_{i=1}^{l}
(w^Tx_i - y_i)^2  \\&= \dfrac{1}{l}||Xw - y|^2  \end{split}$ 

---

#### Classification loss
*Iverson bracket* : ` get 1 point if true else 0 `
> It just a ratio about accuracy  !
* cant use GD to optimize it
* Theres no differece between 2 same prediction exsample

Maybe using squared error?
> Fine ! but we will even get penalyy for high confidence !

Solution: just fix it ! many loss function look like this
![](https://i.imgur.com/SRvUzNn.png)
>  exactly smae cost function for Logistic Regression from 吳恩達's ML course

Softmax transform : 
$z = (w_1^Tx,...w_K^Tx) \to (e^{z_1},...,e^{z_K})\to \sigma(z)\to(\dfrac{e^{z_1}}{\sum_{k=1}^Ke^Z_k},...,\dfrac{e^{z_K}}{\sum_{k=1}^Ke^Z_k},...)$

*Cross entropy*: minus log of the predicted class probability for true class

![](https://i.imgur.com/gdHE5Bg.png)

### Gradient descent
* easy to implement
* very general, can be applied to any differentiable loss function
* requires less memory and computations(stochastic methods)

Overfitting / [Holdout set](https://zhuanlan.zhihu.com/p/37646822) / Cross-Valid
> What disadvantages do model validation on holdout sample have?
> * It is sensitive to the particular split of the sample into training and test parts
>  * It can give biased quality estimates for small samples

### Regularization - Weight penalty
L1 regularzation : no derivative of the absolute value as zero 
* drives some weight exactly to zero
* learn sparse models 
* cannt be optimized with simple grdient methods

Other regularization
* Dimensionality reduction
* Data augmentation
* Dropout
* Early stopping
* Collect more data

#### Stochastic GD
* Noisy updates lead to fluctuations
* Needs only one example on each step
* Can be used in online setting
* Learning rate should be chosen very carefully

#### Mini-batch GD
> hmm.. kind of same...and so memorlizable

## Momentum 
* tends to move in the same direction as on previous steps
* usally $\alpha = 0.9$ 
* $h_t = \alpha \ h_{t-1} + \eta \ g_t$
* lead more faster converge

## [AdaGrad](https://zhuanlan.zhihu.com/p/29920135)
* $G_j^t = G_j^{t-1} + G_{tj}^2 \\ w_j^t = w_j^{t-1}-\dfrac{\eta_t}{\sqrt G_j^t + \varepsilon}g_{tj}$
* $g_tj$ : gradient with respect to j-th parameter
* Sparate learning rates for each dimension
* Suits for sparse data
* Learning rate can be fixed : $\eta_t = 0.01$
* $G_t^t$ always increases , leads to early stops
* $\varepsilon$ make sure non-zero (disadvantage)

>improve AdaGrad (prevent early stoping)
## RMSprop
$G_j^t = \alpha G_j^{t-1} + (1-\alpha)G_{tj}^2 \\ w_j^t = w_j^{t-1}-\dfrac{\eta_t}{\sqrt G_j^t + \varepsilon}g_{tj}$

## Adam - combine momentum & AdaGrad



[Summary 1](https://zhuanlan.zhihu.com/p/22252270)
[Summary 2](https://medium.com/%E9%9B%9E%E9%9B%9E%E8%88%87%E5%85%94%E5%85%94%E7%9A%84%E5%B7%A5%E7%A8%8B%E4%B8%96%E7%95%8C/%E6%A9%9F%E5%99%A8%E5%AD%B8%E7%BF%92ml-note-sgd-momentum-adagrad-adam-optimizer-f20568c968db)
[Summary 3](http://ruder.io/optimizing-gradient-descent/)


HW:LR/cost/prop/SGD/momentum/RMSprop

---

# Week2

### MLP multi-layer perceptron  (NN)

**recall linear binary classification**
Target: y = 1 or -1
Decision function :$d(x) = w_0 + w_1x_1 + w_2x_2$
Algorithm:$a(x) = sign(d(x))$

**Logistic regression**
predicts probability of positive class (0~1)
Decision function :$d(x) = w_0 + w_1x_1 + w_2x_2 \ \ \ \ (same)$
Algorithm:$a(x) = \sigma (d(x))$
Close to line = not confidence , 0.5 if exactly on line
> if want to non-linear decision line : $h_\theta (x)) = g(\theta_0) + \theta_1x_1 +\theta_2x_2+\theta_3x_1^2+\theta_4x_x^2$

Trying to solve problem this way

![](https://i.imgur.com/rlail4g.png)
![](https://i.imgur.com/yLRVSoX.png)

Dense layer : a hidden layer in MLP

---

### Chain rule -- compute derivatives

### Back-propagation (reverse-mode differentiation)
* apply chain rule efficiently
* fast,becuz reuse computation from previous step
* for each edge we compute its value only once.And multiply by its value exactly once.

> What is the time complexity of backpropagation algorithm w.r.t. number of edges NNN in the computational graph
> O(N)

### Jacobian (Video:Other matrix derivatives)
vector functions (will be useful for RNN): 
input and output all vetor

$g(x):(x_1,...,X_n)\to (g_1,...,g_m) \\ f(g) :(g_1,...g_m) \ to (f_1,...f_k)\\ h(x) = f(g(x)):(x_1,...,x_n)\to (h_1,...,h_k)= (f_1,...f_k)$

The matrix of partial derivative $\dfrac {\partial hf_i}{\partial x_j}$ is called the Jacobian:

![](https://i.imgur.com/AhIjOzh.png)

### Tensor

![](https://i.imgur.com/NowE0he.png)

* IN DL frameworks, we need to cal grdients of a scalar loss with respect to another scalar, vector , matrix, or tensor.
* This's how tf.gradients() in TensorFlow works
* DL frameworks have optimized version of backward pass for standard layers

---

* For vector functions chain rule says that u need to multiply respective Jacobians
* Matrix by matrix derivative is a tensor
* Chain rule for such tensors is not very useful in practice
* Thankfully,in DL frameworks we usually need to track gradients...(just like above)

---

# TensorFlow

* A tool to describe computational graphs
    * The foundation of computation in TF is the Graph object.This holds a network of nodes, each representing one operation, connected to each other as inputs and outpus.
* A runtime for execution of these graphs
    * On CPU, GPU, TPU, ...
    * On one node or in distributed mode 

### Input
* Placeholder
    * This is placeholder for a tensor, which will be fed during graph execution 
    * x = tf.placeholder(tf.float32,(None,10))
* Variable
    * This is a tensor with some value that is updated during execution
    * w = tf.get_variable("w",shape=(10,20),dtype=tf.float32)
    * w = tf.Variable(tf.random_unifor((10,20)),name="w")
* Constant
    * This is a tensor with a value, that cannot be changed
    * c = tf.constant(np.ones((4,4)))

### Operation example
* Matrix product:
```
x = tf.placeholder(tf.float32,(NOne,10))
w = tf.Variable(tf.random_uniform((10,20)),name = "w")
z = x @w
#z = tf.matmul(x,w) (python2)
print(z)
```
* Output:Tensor("matmul:0",shape=(?,20,dtype=float32)
* We dont do any computations here,we just **define** the graph

### Computational graph 

![](https://i.imgur.com/ayMPM0m.png)

![](https://i.imgur.com/wJiv6i8.png)

### Operations

![](https://i.imgur.com/TbjALPQ.png)

![](https://i.imgur.com/BFlPsj4.png)

![](https://i.imgur.com/pWqT3WH.png)

![](https://i.imgur.com/MxSKUq8.png)
![](https://i.imgur.com/OnGtgsI.png)
![](https://i.imgur.com/9AiJ5vw.png)
![](https://i.imgur.com/qIfUEpI.png)

---

![](https://i.imgur.com/JoZJqx2.png)
0.1 = learning rate
var_list = Compute gradients of loss for the variables in var_list
![](https://i.imgur.com/D7rjvDh.png)
You can set it untrainable (in transfer learning or face detection i think?)
![](https://i.imgur.com/CaDTPXr.png)
Seems good,but values are not synchronized
bucuz when running session, order is not fixed
x is already smaller than the respective value of f
![](https://i.imgur.com/zoCPYap.png)
f = tf.Print wont change value but print
not visible in Notebook becuz its a bug in TF ans still not resolved ==
![](https://i.imgur.com/nZefaKv.png)









logs/1 = where to store  s.graph = run number
![](https://i.imgur.com/pDf5nvx.png)

![](https://i.imgur.com/5Et4KcA.png)
![](https://i.imgur.com/4dbrrwY.png)






















![](https://i.imgur.com/fcgaG1h.png)
![](https://i.imgur.com/96gzN1y.png)

![](https://i.imgur.com/xFs9KcQ.png)









![](https://i.imgur.com/g43fcCU.png)
![](https://i.imgur.com/4vvlYe8.png)

[more thing](http://jacobbuckman.com/post/tensorflow-the-confusing-parts-1/)[ article 2](https://www.tensorflow.org/tutorials)[ document](https://github.com/tensorflow/docs/tree/r1.3/site/en/api_docs)



### Deep Learning

DL isnt magic
* No core theory - relies on intuitive reasoning
* Need tons of data
* Computationlly heavy - running on mobile/embedded is a challenge

### Deep learning is a (machine learning) language
> in which u can hint ur model on what u want it to learn

* For images
    * I want to classify cats regardless where they are
    * I don't want model to be indifferent to small shifts
* For texts
    * Model should reconstruct the underlying process
* In general
    * I dont want model to trust single feature too muck
    * I want my features to be sparse

[next](https://hackmd.io/CJsYepQ1TdKaFy-E2mpLgg#)

###### tags: `Machine Learning` 