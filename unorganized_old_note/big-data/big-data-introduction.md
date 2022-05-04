big-data-introduction
===

## week1

Big Data Value: Dada -> Information > Knowledge > Wisdom

unstructured data (80%~90% data of the world)
* Text-heavy
* Unstructured

Data Acquisition > Storage > Retrieval > Cleaning > Processing

Hight Velocitu Data:
framework handle such real time data generated at a fast rate
* Apache STORM
* Spark

![](https://i.imgur.com/Px1zyvw.png)

Nosql:scalable
graph database:Neo4j

Gererated data from organizations:varies

![](https://i.imgur.com/HtbFJSK.png)

Data Silos > Hindered opportunity generation, Unconnected infromation islands > Outdataed, unsynchronized, even invisible data

Data Integration: Turning complex data into usable
> in all shapes and sizes: flat file / Relational / XML / JSON

* Reduce data complexity
* Increase data availability
* Unify ur data system

> Increase data collaboration

## week2

big data: Volume Velocity Variety Veracity Valence Value
Veracity: biases
Valence: connectedness of big data


### Volume == Size

Challenges:Storage, Data acquisition, Retrieval --Distribution--> Processing

### Variety == Complexity

Structural Variety:formats and models
Media Variety:medium in which data get delivered
Semantic Variety:how to interpret and operate on data(unit)
Availability Variations:real-time?Intermittent?(eg: traffic cam)

### Velocity == speed

Batch Processing(still common now)(slow)(incomplete)
Collect Data > Clean > Feed in Chunks > Wait > Act

Real-Time Processing(fast)
Instantly capture streaming data > Feed real time to machines > Process Real time > Act


### Veracity == Quility(Validity/Volatility)

Accuracy / Reliability of data source / context within analysis

* Uncertainty
* Provenance

Aggregate Uncertainty :Senesors(internet of things) > Social Media(video, audio, text) > VoIP > Enterprise Data


### Valence == Connectedness

data connectivity increases over time(make analytic inefficient)

Challenges
* More complex data exploration algorithms
* Modeling and prediction of valence changes
* Group event detection
* Emerge behavior analysis


### Value

---

Strategy

* Aim
* Policy
* Plan
* Action

Share data:remove barriers to data access-no data silos

[5P of data science](https://words.sdsc.edu/words-data-science/data-science)

### Asking the right questions

* Risks
* Benefists
* Contingencies
* Regulations
* Resources
* Requirement

Define Golads: Objectives, Criteria

### Data Science Process

* ACQUIRE
    * Identify data sets
    * Retrieve data
    * Query data
* PREPARE
    *  2-A:Explore
        *  Understand nature of data
        *  Preliminary analysis
    *  2-B:Pre-process
        *  Clean
        *  Intergrate
        *  Package
* ANALYZE
    * Select analytical techniques
    * Build models
* REPORT
    * communicate result
* ACT
    * apply results

### Acquiring data

Remote data:SOAP/REST(most)/WebSocket
XML/HTML/JSON/RSS

NoSQL > API, WebServices

Text files: Scripting languages

### 2-A Exploring

![](https://i.imgur.com/voqRieP.png)

Statisics:mean/median/mode/range

Visualize

### 2-B Pre-Processing

Issues:
* Inconsistent
* Duplicate records
* Missing values
* Invalid data
* Outliers

Clean+Transform

Data Munging:
* Dimensionality Reduction
* Data Manipulation
* Transformation
* Feature Selection
* Scaling

### Analyzing Data

Classification/Regression/Clustering/Graph ANalytics/Association Analysis

### Communicating Results
Visualization
R/python/D3/Leaflet/Tableau/Google Charts/Timeline


## week3

Distributed file system
Data partitioning, Data replication > Data scalability, Falut tolerance, High concurrency

parallel computer:Expensive
Commodity Cluster:Affordable, Less-specialized

Distributed Computing:Computing in one or more of these clusters 

Data-parallel scalability>Potential for node-level system failures>Redundant data storage, Data-parallel job restart

Programming Model = abstractions:Runtime Libraries + Programming Languages

1.Support Big Data Operations

* Split volumes of data
* Access data fast
* Distribute computations to nodes

2.Handle Fault Tolerance

* Replicate data partitions
* Recover files when needed

MapReduce> A programming model for Big Data> Many implementations

Support large data volumes, Provide fault tolerance, Enalbe scale out > MapReduce

---

Hadoop

1.Enable Scalability:Commodity hardware is cheap
2.Handle Fault Tolerance
3.Optimized for a Veriety Data Types
4.Facilitae a Shared Environment
5.Provide Value:Community-supported, Wide range of applications

![](https://i.imgur.com/fRRSpA3.png)


Layer Diagram(stack)
Higher levels:interactivity
Lower levels:Storage and scheduling

YRAN:flexible scheduling and resource management

MapReduce:Simplified programming model
Map->apply()
Reduce->summarize()

Higher-level programming models
Pig=dataflow scripting
Hive=SQL-like queries

Specialized models for graph processing:Giraph

Real-time and in-memory processing:Storm, Spark, Flink

NoSQL for non-files:Key-values, Sparse tables
* HBase
* Cassandra
* MongoDB

Zookeeper for management:Synchronization, Configuration, High-availability


pre-built stacks
* Cloudera
* MAPR
* Hortonworks

### HDFS

HDFS splits files across nodes for parallel access

Replication for fault tolerance (copy prevent from loss)

Key components

* NameNode for metadata
    * Usually one per cluster
* DataNode for block storage
    * Usually one per machine


NameNode:coordinator of HDFS cluster
Keeps track of file name, location in directory
Mapping of contents on DataNode

DataNode stors file blocks
Listens to NameNode for block operation, deletion, replication(Fault Tolerance, Datalocality)


Data partitioning> Scalability
Data replication>Fault toerance, Data locality

---
### YARN


![](https://i.imgur.com/QnsJD4K.png)

Central Resource Manager == ultimate decision maker
Each mahcine gets a Node Manager

Resource Manager + Node Manager = Data Computation Framework

Container = a machine 
Application Master = Personal Negotiator

Data>Value
One dataset>Many aaplications
Higher esource Utilization>Lower Cost

### MapReduce:Simple Programming for Big Results


Parallel programming = Requires expertise:
* Semaphores
* Threads
* Message Passing
* Locks
* Monitors
* Shared Memory

but MapReduce = Only Map and Reduce! (none of above)

f(x) = y

Map = apply operation to all elements
Reduce = summarize operation on elements


WordCount read files, count the number of occurences of each word > Result file

Step1:Map on each node
> Map generates key-value pairs

Map goes to each node containing a data block for the file, insteaf of the data moving to map

Step2:Sort and Shuffle
> Pairs with same key moved to same node

Step3:Reduce
> Add values for same keys

Map>Shuffle and sort>Reduce
> Represents a large number of applications

Try replace the number to refer to URLs
apple -> http://apple1.fake, http://apple2.fake

![](https://i.imgur.com/QxrUkQh.png)


Map: Parallelization over the input
Shuffle and Sort: Parllelizaiton over intermediate data
Reduce:Parallization over data groups

MapReduce bad for:
* Frequently changing data:slow since it reads the entire input data set each time
* Dependent tasks:MapReduce model requires thats maps and reduce execute independently each other
* Interactive analytic:doesnt return any results until finished

---

When to reconsider Haddop?
* Future anticipated data growth
* Long term availabilit of data

* Many platforms over single data store
* High Volume
* High Variety

Caution:
* Small Datasets
* Task Level Parallelism
* Advanced Alogrithm
* Replcament to ur infrastructure
* Random Data Access

Moving targets in Hadoop ecosystem and new tools
* Advanced Analyical Queries
* Latency sensitive tasks
* Security of Sensitive Data

---

Cloud Computing 


Computing anywhere and anytime:On-Demand Computing

Cloud = IT infrastrucutre &　Applcaitons on "Rent" over the Internet

Hardware is hard to build urself, a lot of issues to slove

Cloud:
* Pay as u go
* quick implementation
* deploy closer ur client
* resource estimation sloved
* work on ur domain expertise
* instantly get different resources(CPU, GPU)
* Design ur own computing platform (CPU, MEMORY, DISK)

---

Cloud Service Models
(bottom to top)


IaaS = Get the hardware only
install and maintain OS application Softwate:virtual machines, servers, storage, network...

Paas = Get the computing environment
Application Software:Execution runtime, database, webserver

SaaS = get full software on-demand
Domain Goals:CRM, Email, virtual desktop, game..


Cloud Clients:Web browers, mobile app, thin client...

---

Pre-built image for Hadoop

Hortonworks Sandbox

Clodera


---

hadoop fs -copyFromLocal words.txt
hadoop fs -ls
hadoop fs -cp words.txt words2.txt
hadoop fs -copyToLocal words2.txt
hadoop fs -rm words2.txt

hadoop jar /usr/jars/hadoop-examples.jar
The output says that WordCount takes the name of one or more input files and the name of the output directory. Note that these files are in HDFS, not the local file system.


Hadoop comes with several example MapReduce applications. You can see a list of them by running hadoop jar /usr/jars/hadoop-examples.jar

hadoop jar /usr/jars/hadoop-examples.jar wordcount
hadoop jar /usr/jars/hadoop-examples.jar wordcount words.txt out
hadoop –fs ls out
The file part-r-00000 contains the results from WordCount. The file _SUCCESS means WordCount executed successfully.

hadoop –fs ls out
hadoop fs –copyToLocal out/part-r-00000 local.txt
more local.txt


###### tags: `Big Data`
