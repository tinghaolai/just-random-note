Big-Data-Machine-Learning
===

[My own environment setup solution answer](https://www.coursera.org/learn/big-data-integration-processing/discussions/weeks/4/threads/Pvcw4wmPEee36g5uvZCkbA)


# Week1 
* learning from data
* no explicit programming
* discovering hidden patterns
* data-driven decisions
---

* Machine Learning
    * statistics, artifical intelligence, computer science, algorithms and techniques used to learn from data.
* Data mining
    * refer to activities realted to finding patterns in DB/data warehouses
    * Others: similar to ML
* Predictive analytics
    * used in the business context
* Data science
    * processing and analyzing data to extract meaning

## Categories of ML Techniques
Classification
Regression
Cluster Analysis
Association Analysis
> Find rules to capture association between items
> * Recommend items based on purchase/browsing history
> * Have slaes on realted items often purchased together
> * Identify web pages accessed together

Superviesd vs Unsupervised

---

### ML Process
ACQUIRE > PREPARE > ANALYZE > REPORT > ACT
> Already explained in previous course


## CRISP-DM
process model that describes the steps in a data mining process

==CRoss Industry Standard Process for Data Mining==

![](https://i.imgur.com/wUDS5BE.png)


* Business Bunderstandering
    * Define problem or opportunity
    * Assess situation
    * Formulate goals
* Data Understanding
    * Data acquisition
    * Data exploration
* Data Preparation
    * Prepare data for modeling
    * Address quality issues, select features to use, process data for modeling
* Modeling
    * Determine type of problem
    * Select modeling techniques to use
    * Build mmodel
* Evaluation
    * Access model performance
* Evaluate model results with respect to sucess criteria
* Deployment
    * Produce final report
    * Deploy model
    * Monitor model

very similar to previous

## Scalability and Tools

* Scale up
    * Using one big machine
    * Add more hardware
    * Use specialized hardware
* Problem
    * Costly solution
    * Will eventually reach a limit

### ML at Scale
* Scale out
    * Use commodity hardware
    * Use distributed approach
    * Distribute data over cluster of machines

Speedup: sequential execution: N * T
parallel execution: N/4 * T +O
o : overhead to merget subset results

* Distribute data across processors
* Allow for machine leraning at scale
* Operate on distributed computing platforms


### Tools used

* KNIME
    * Platform for data analytics, reporting, and visualization
    * GUI-based approach with drag-and-drop interface
    * Nodes provide functionality
    * Nodes are assembled to create workflows
    * Workflow
        * Visual representation of steps in analysis process
        * Workflow is composed of nodes
        * KNIME Node
            * Read Data(File Reader) --connection->--(input port) Build Decision Tree(Decision Tree Learner)-->(output port)
        * Node Repository
            * Contains nodes organized by category
* Spark MLlib
    * Scalable ML libray
    * Runs on Spark
        * Distributed computing platform
    * Write code to implement ML operations
    * Provides APIs for Java Scala Python R

---

# Week2

### Terminology
Samples/row/instance/obervation/example/record
Variables/feature/column/dimension/attribute/field

### Data Types
Numeric(quantitative), Categorical(qualitative, nominal), String, Date, ...


### Data Exploration
> Already explained

## Data Exploration through Summary Statistics

### Summary statistics
* Quantities that summarize and describe a set of data values
* Measures of 
    * Location: mean, median
    * Spread: standard deviation
    * Shape: skewness(asymmetrically), kurtosis(tail)

* Measures of Dependence Describe relationship between variables
    * contingency table
* Check Dimensions
* Chech Values/Missing Vlues

## Data Exploration thourgh Plots


* Histogram
    * Shows distribution of numeric variables
    * Central Tendency
    * Skewness
    * Outlier
* Line plot
    * Shows change in data over time
    * Cyclical pattern
    * Trend
    * Compare variables
* Scatter plot
    * Shows realationship between two variable
    * Correlation(Pos/Neg/Non-Linear/No-Corr)
* Bar plot
    * Shows distribution of categorical variable
    * Grouped Bar Chart
    * Stacked Bar Chart
* Box plot
    * Compares distributions of variables
    * The middle 50% of data are in box region
    * ![](https://i.imgur.com/SToKIWU.png)
* others


---

## Hands-on
### Exploring Data with KNIME Plots
file reader browse the csv file.
histogram and drag, execute file reader and setting integrate and column
scatter plot to check the relationship
numeric binner : add 5 bin about direction(NENW)(1-N :-inf to 45 and 315 to inf) to append new column
finally drag another histogram to view(bin set:25)
add another numeric binner to humidty and connect with conditional box

### Data Exploration in Spark
put csv to dataframe, cloudera image has only Spark1, so we need to put argument.(We don't need at Spark2)
df.describe('air_pressure_9am').show()
df2 = df.na.drop(subset=['air_pressure_9am'])
df2.stat.corr('rain_accumulation_9am', 'rain_duration_9am')


---

## Data Preparation for ML

Goal: Create data for analysis
* Clean
* Format
    * Select features to use
    * Transform data
### Data　Cleaning(Data Cleansing)
* Data quality issues
    * Missing values
    * Duplicate data
    * Inconsistent data
    * Noise
    * Outliers
* Addressing Data Quality Issues
    * Remove data with missing values
    * Merge duplicate records
    * Generate best estimate for invalid values
### Data Wrangling(Data Munging/ Data Preprocessing)

* Feature selection
    * Combing features
    * Adding/Removing features
* Feature transformation
    * Scaling
    * Dimensionality reduction
### Data Quality
* Missing Data
* Duplicate Data
    * ![](https://i.imgur.com/5CViQVD.png)
* Invalid Data
* Noise
    * ![](https://i.imgur.com/yGFWlRB.png)
* Outilers
    * ![](https://i.imgur.com/07e6qhd.png)
### Addressing Data Quality Issues
* Removing Missing Data
    * Delete the row with missing data
        * easy but losing data
    * Replcae missing values with something reasonalbe
        * Mean
        * Median
        * Most frequent
        * Sensible value based on application
* Duplicate Data
    * Delete older record
    * Merger duplicate records
* Invalid Data
    * Use external data source to get correct value
    * Apply reasoning and domain knowledge to come up with reasonalbe value
* Noise
    * Filter out noise component
    * May also filter out part of data, so care must be taken
* Outliers
    * Remove outilers if they're not focus of analysis
    * Analyze more closely if they are focus of analysis(e.g: frqud detection)

Domain Knowledge
> Required for addressing data quality issues effectively

### Feature Selection ( Feature Engineering)
> Characterize problem with smallest set of features

find balance between Expressiveness and Size

* Feature Selection Methods
    * Remove feature
        * Features that are very correlated
        * Features with a lot of missing values
        * Irrelevant fequtres: ID, row number, etc.
    * Re-code feature
        * Examples
            * Distretization: re-format continuous feature as discrete
            * Customer's age => {teenager, youung adult, adult, senior}
        * Breaking Up Features
    * Combine features
    * Add feature
        * New features derived from existing features

Summary - Goal: Select smallest set of features that best captures data for application

### Feature Transformation

![](https://i.imgur.com/UE7ZSsj.png)

* Scaling
    * Scaling to a Range
    * Zero-Normalization / Standarlization
        * Mean = 0
        * Standard Deviation = 1
* Filtering
    * Remove grainy apperance in images
* Aggregation
    * e.g: ploting- every 10 min to every 60 min
* What
    * Map feature valuews to new set of values
* Why
    * Have data in format suitable for analysis
* Caveat
    * Take cate not to filter out important characteristics of data

### Dimensionality Reduction
* Cures of Dimensionality
    * Dimension goes up
        * Data gets incresingly sparse
            * Analysis results degrade
* Keep important dimensions / Drop irrelevant dimensions
* Principla Component Analysis
    * Fins a new corrdinate system such that
        * PC1 captures greatest variance
        * PC2 captures second greatest variance, etc
        * PC3, etc
    * First few PCs capture most of variance
        * Define lower-dimentsional space for data
* More difficult to interpret

---

## Hands-on
### Handling Missing Values in KNIME
Missing Value (Node) - list with function to do with missing value
> apply to whole data or specific column
copy node(same setting)
### Handling Missing Values in Spark
```Python
df.count()
removeALLDF = df.na.drop()
removeALLDF.describe(['air_temp_9am']).show()
removeALLDF.count()
from pyspark.sql.functions import avg
imputeDF = df
for x in imputeDF.columns:
    meanValue = removeALLDF.agg(avg(x)).first()[0]
    # .first() get the first row and first value with[0]
    print(x, meanValue)
    imputeDF = inputeDF.na.fill(meanValue, [x])
df.describe(['air_temp_9am']).show()
imputeDF.describe(['air_temp_9am']).show()

```




# Week3
## Classification
Supervised
> Skip
### Building and Applying a Classification Model
ML Model
> * A mathematical model with parameters that map input to output
> * Model parameters are adjusted during model training to change input-output mapping

* Training Phase
    * Adjust model parameters
    * Use training data
* Testing Phase
    * Apply learned model
    * Use new data
Use leraning algorithm to model parameters during training.

### Classification ALgorithms

* kNN
    * k Nearest Neighbors
    * Classify sample by looking at its closest bighbors
    * No separate training phase
    * Can generate complex decision boundaries
    * Can be slow
        * Distance between new sample and all samples must be computed to classify new sample
* Decision Tree
    * Tree caputrues multiple calssification decision paths
    * Idea: Split data into "pure regions
    * Root Node/ Leaf Nodes / Internal Nodes / Tree Depth / Tree Size
    * Nods(condition) -> Leaf(classification)
    * Constructing Decision Tree (Tree Induction)
        * Start with all samples at a node
        * Partition samples based on input to create purest subsets
        * Repeat to partition data into successively purer subsets
    * Greedy Approach
    * Best Split: More homogeneous = More pure
        * Impurity Measure
            * common one: Gini Index(lower and better)
            * Others: entropy, information gain, miscalssification rate
    * When to Stop?
        * ALL (or X%) samples have same class label
        * Number of samples in node reaches minimum
        * Change in impurity measure is smaller than threshold
        * Max tree is reached
        * Others
    * Decision Boundaries
        * Rectilinear = Parallel to axes
        * There are variance of TI algorithm that consider more than one attrebute when splitting a node
            * much more computationally expensive
    * Summary
        * Resulting tree if oftern simple and easy to interpret
        * Induction is computationally inexpensive
        * Greedy approach does not guarantee best solution
        * Rectilinear decision boundaries
    
* Naive Bayes
    * Probablilistic approach to calssification
        * $probbability=\dfrac{event/s}{number\ of\ outcomes}$
    * Probabilistic approach to calssification
        * Relationships between input features and class expressed as probailities
        * Label for sample is class with highest probalility given input
    * Naive Bayes Classifier
        * Classification Using Probability
            * $P(A)=\frac{\#ways\ for\ A}{\#possible outcomes}$
            * Joint Probability
                * Probability of events A and B occurring together
            * Conditional Probability
                * $P(A|B)=\dfrac{P(A,B)}{P(B)}$
        * Bayes Theorem(Rule/Law)
            * relationship between P(B|A) and P(A|B) can be expressed through Byyes'Thorem
                * $P(A|B)=\dfrac{P(B|A)P(A)}{P(B)}$
            * For Classification
                * estimating P(C|X) is difficult
                * to the rescue
                    * Simplifies problem
                * P(B) : Constant(can be ignored)
        * Feature Independence Assumption
            * Features are independeent of one another
                * $P(X_1,X_2,...,X_n|C)=P(X_1|C)*P(X_2|C)*...*P(X_n|C)$
                * only need to estimate individually>Much simpler
        * Fast and simple
        * Scales well
        * Independence assumption may not hold true 
            * In practive, still works quite well
        * Does not model interations between features

---

## Hands-On
### Classification using Decision Tree in KNIME

* File Reader
    * Statistics
    * Missing Value
        * Numeric Binner
            * Statistics
            * Column Filter
                * Color Manager
                    * Partitioning
                        * Decison Tree Learner
                        *   * Decision Tree Predictor
### Classification on Spark
* drop na
* Binarizer(threshold, input, output).transform
* VectorAssembler
* assembled.randomSplit
* DecisionTreeClassifier
* Pipeline(stages=[dt])
* prediction = model.transform

---

## Quiz
"]"
> include
if "append new column" not checked?
> become a categorical variable

---

# Week 4
## Generalization & Overfitting
### Errors in Classifcation
* Success: Output = Target
* Error / Error rate
* Test error indicates how ell model will perform on new data

### Generalization
* Performs well on new data -> Good Generalization
* Test Error = Generalization Error
### Overfitting
> Poor Gneralization
* Overly complex model
### Overfitting in Decision Trees
If nodes are fitting to noise in training data, model will not generalize well
* Avoiding
    * Pre-Pruning()
        * Stop growing tree before fully grown
            * have aslo implement in climb algo
            * number of records< some threshold
            * improvement in impurity measure < some threshold
    * Post-Pruning
        * Grow tree to max size, then prune 
            * remove nodes from bottom up
            * replcae subtree with leaf node if generalization error improves or does not change
> Post: more often but more computational expensive

### Using a Validation Set
Used to determine when to stop training to avoid overfitting
* Holdout method
    * Holdout set used to determine when training should stop
    * Repeated Holdout
        * Repeating serveral times
        * Randomly select different hold out set
        * Average validation errors over all repetitions
* K-fold cross-validation
    * > well, most fimilar one
* Leave-one-out cross-validation
    * > Same as K-fold but one 1 valid for each iter

Uses of Validations Set: 
* Address overfitting
* Estimate generalization performance

## Model evalutation metrics and methods
Types of Classification Errors
* True Positive
* T Negative
* False Pos
* F Neg

Accuracy
> Bad as u know

* Precision
    * TP/(TP+FP)
* Recall
    * TP/(TP+FN)

==F-Measure==
* F1:2* P*R/(P+R)
* F1:evenly weighted
* F2:Recall more
* F0.5:Precision more

## Confusion Matrix
count
![](https://i.imgur.com/EqNPDZG.png)
correct : 7 out of 10 = 0.7

> yeah..I donno why this deverses 7 min vid

## Hands-on
### Evaluation of Decision Tree in KNIME
Decision Tree Predictior:
add 3 component at the end:
Scorer, Interactive Table, Scatter Plot
### in Spark
MulticlassClassificationEvaluator
predictions.rdd.take(2)
MulticlassMetrics
metrics.confusionMatrix().toArray()

# Week 5
## Regression
### Regression Overview
* Predict number from input variables
* Regression is a supervised task
* Target variable is numerical
### Linear Regression
* Captures relationship between numerical output and input variables
* Relationship is modeled as linear

==Least Squares Algorithm==
* y = mx + b
* Training linear regression model adjusts model parameters to fit samples
* Find regression line that makes sum of residuals as small as possible

==Types==
Input has one/>1 variable

## Cluster Analysis
### Overview
* Goadl : Organize similar items into groups
* Divides data into clusters
* Similarity Measures
    * Euclidean Distance
    * Manhattan Distance
    * Cosine Similarity
* Interpretation and analysis required to make sense of clustering results
    * Unsupervised
    * There is no correct clustering
    * Clusters dont come with labels
* Data segmentation
    * Analysis of each segment can provide insights
## k-Means　Clustering
> Cant be any more fimilar to me
## Association Analysis
* Find rules to capture association between items
* Interpretation and analysis requqired to make sense of resulting rules
    * Unsuperviesd
    * Usefulness of rulse is subjective
    * Need to determine how to use rules

## Association Analysis in Detail
* Steps
    * Create item sets -> Identify frequent item sets
        * Support = frequency of item set
        * Remove the item sets since they have low support
        * 1-Item Sets, 2-Item Sets, ...
    * Generate rules
        * (Antecedent) X -> Y (Consequent)
        * Rule Confidence
            * $conf(X\to Y)=\dfrac{supp(X\cup Y)}{supp(X)}$
        * Itemset Support
            * $supp(X)=\dfrac{\# transactions with X}{total \# transactions}$

==Rule Generation & Pruning==
* frequent item sets -> association rules
* each k-item set -> $2^k-2$ rules
* frequent item sets -> Significant rules
    * Use rule confidence to constrain rule generation
    * Keep rule if confidence > minimum condidence
### Association Analysis Algorithms
* Use different methods to make efficient:
    * item set creation
    * rule generation efficient
* Algorithms:
    * Apriori
    * FP Growth
    * Eclat
---
## Quiz
Cluster results can be used to
> Create labeled samples for a classification task
> Classify new samples
> Segment the data into groups so that each group can be analyzed further 
> Determine anomalous samples

## Hands-on
### Cluster Analysis in Spark
filter, drop
VectorAssembler, transform
StantdardScakerm, fit, transform
scaledData, filter, persist
==training== range, elbow
elbow_plot
Kmeans, fit, transform, model.clusterCenters()
P: utils.pd_centers
* paralle_plot
    * condition
    * union

---

## Quiz

Why is it necessary to scale the data (Step 4)?
> Since the values of the features are on different scales, all features need to be scaled so that no one feature dominates the clustering results.



###### tags: `Big Data`

