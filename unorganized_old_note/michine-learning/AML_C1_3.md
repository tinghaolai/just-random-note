AML-C1-Week 3 : Advanced Machine Learning - Couse 1 Introduction to Deep learning(week 3)
===

[prev](https://hackmd.io/LIRrh_WRS-qv_OMdt9zfjA?both)

### Week 3

### Image as a NN input

$x_{norm} = \dfrac x {255}- 0.5$


![](https://i.imgur.com/rHaL0Da.png)

### Convolutions will help !

* Edge detection
* Sharpening
* Blurring














![](https://i.imgur.com/upXLpQB.png)

![](https://i.imgur.com/JnAc4WD.png)

> Convolutional layer can be viewed as a special case of a fully connected layer when all the wieghts outside the *local receptive field* of each neuron equal 0 and kernel parameters are shared between neurons.

![](https://i.imgur.com/DWlrWzm.png)

![](https://i.imgur.com/qO3hzV3.png)

So... we have stride to grow receptive field faster.

But! How do we maintrain translation invariance?

![](https://i.imgur.com/9ahSIc0.png)

So... we have Pooling layer. Dont have kernel, wont change depth.

![](https://i.imgur.com/XJJu9xv.png)

> Maximum will change linearly : means that we have a gradient of 1

![](https://i.imgur.com/Fzr6Rbp.png)


### Learning deep representations

Neurons of deep convolutional layers learn complex representations that can be used as features for classification with MLP.

### Sigmoid activation when bakcpropgation


**Sigmoid**
![](https://i.imgur.com/tQRojtf.png)

* Vanishing Gradients
* Not zero-centered
    * Input have normalized
    * not a big case
    * 意思是幾層計算之後就沒有zero-centered? 也沒解釋
* $e^x$ is compuatationlly expensive

**Tanh activation**
![](https://i.imgur.com/3eZ0lnz.png)
* Zero-centered.
* ***But still pretty much like sigmoid***

**ReLU activation**

![](https://i.imgur.com/RBH9SIA.png)

* Fast to compute
* Gradient do not vanish for x>0
* Provides faster convergence in practive
* ==Not zero_centered==
* ==Can die if not activated, never updates(unlucky enough)== 


**Leaky ReLU activation 

![](https://i.imgur.com/5Y3SFEq.png)

* Will not die ^^
* a != 1

* Linear models work best when inputs are normalized
* Neuron is a linear combination of inputs + activation
* Neuron output will be used by consecutive layers

If E(X) and E(W) = 0, E(X*W) = 0  E=expected value
But variance can grow with consecutive layers, it hurts convergence for deep networks!

varience = 方差 (?)
![](https://i.imgur.com/WVBrHKm.png)

![](https://i.imgur.com/Y30PEPq.png)

Batch normalization controls mean and variance of outputs **before activations**

![](https://i.imgur.com/rgK3ZDn.png)


### Dropout

During testing all neruons are present but their outputs are multiplied by p to maintain the scale of inputs.
Expected input weight:$p* w+(1-p)*0$

![](https://i.imgur.com/kRnCqYz.png)
![](https://i.imgur.com/iEXbD7h.png)
![](https://i.imgur.com/JV9aMU6.png)

![](https://i.imgur.com/0TVZRpt.png)
![](https://i.imgur.com/ubn4RtD.png)
> Why it work better?In simple NN architecture have a fixed size of a kernel in convolutional layer, if use different scales then u can use all features and learn better.

![](https://i.imgur.com/LzUhCma.png)
![](https://i.imgur.com/lCLx5Sf.png)
> Lets use the same idea in our inception block
![](https://i.imgur.com/3p2PtvK.png)
> These used in inception V3 architecture
![](https://i.imgur.com/d8bpbj4.png)
![](https://i.imgur.com/ipQIqXb.png)
> That provides a better gradient flow during back propagation(well... not clear...)

---

Transfer learning

![](https://i.imgur.com/ylExJb7.png)

* You can initialize deep layers with values from ImageNet.
* This is called **fine-tuning**, becuz u dont start with a random init.
* Propagate all gradient with smaller learning rate.

#### Fine-tuning
* Very frequentyl used thanks to wide spectrum of ImageNet classes
* Keras has the weight of pre-trained VGG, Inception, ResNet architectures
* U can fine-tune a bunch of different architectures and make an ensemble out of them.

![](https://i.imgur.com/9MjLKQ8.png)

![](https://i.imgur.com/RvWtdUy.png)

![](https://i.imgur.com/XV8m7MA.png)

Final layer: number of classes
We go deep but dont add pooling, too expensive & hard to train.

![](https://i.imgur.com/oGb0FAc.png)

After 3 convolution & pooling 2, wait ! We need to classify each pixel, need to do unpooling.

### Nearest neighbor unpooling
Fill with nearest neighbor values
![](https://i.imgur.com/pJ2g6ql.png)

### Max unpooling

![](https://i.imgur.com/mPr11CK.png)
![](https://i.imgur.com/EVmC2Cs.png)
![](https://i.imgur.com/64n6BQT.png)
![](https://i.imgur.com/MASz4IO.png)
![](https://i.imgur.com/gBRJwjZ.png)

---

Week 5

# Unsuperviese learning
* Find most relevant features
* Compress information
* Retrieve similar objects
* Generate new data samples
* Explore high-dimensional data

## Autoencoders
Main idea: Take data in some original (high-dimensional) space;
Project data into a new space from which it can then be accurately restord.

* Encoder = data to hidden
* Decoder = hidden to data
* Decoer(ENcoder(x)) ~ x


![](https://i.imgur.com/9FdDsWf.png)

Why?
* Compress data
    * |code| << |data|
* Dimensionality reduction
    * Before feeding data to ur XGBoost
 
 
 ![](https://i.imgur.com/o1iw5vr.png)

 
Similar to you if u use scikit-learn or caret : `Simple component analysis` `Singular value decomposition` `non-negative matrix factorization`
> But the general idea behind all thos methods is theay take a large matrix.

![](https://i.imgur.com/9LkmjEx.png)

What if insufficient and make it nonlinear with address?
![](https://i.imgur.com/VZQSoFB.png)

![](https://i.imgur.com/mMUAL1g.png)

In the middle : Dense H = 256 / Conv 32x5x5 pad 2



###### tags: `Machine Learning` 
