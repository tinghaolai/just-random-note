Big Data Modeling and Management Systems
===

# week1

The goal of data mdoeling is to formally explore the nature of data

Whats Data Management?
> Q about Data Application

* How do we ingest the data?
* WHere and how do we store it
* How can we ensure data quility
* What operation do we perform on the data
* How can these operations be efficient
* How do we scale up data volume, variety, velocity and access
* How to keep the data secure


### Data Ingestion

* How many data sources
* How alrge are data items
* Will the number of data sources grow
* Rate of data ingetstion
* Ingestion Policy
    * What to do with bad data
    * What to do when data is little or too much


### Data Storage

* How much data to store?
    * Directly attached?
    * Network attached?
* How fast do we need to read/write
    * Memory Hierarchy

### Data Quality

* Better quality means better analytics and decision making
* Quality assurance means needed for regulatory compliance
* Quality leads to better engagement and interaction with external entities

* Data profiling and data qualitu measurement
* Parsing and standardization
* Generalized cleansing
* Matching
* Monitoring
* Issue resolution and workflow
* Enrichment

### Data Operations

* Operations on single data items that produce a sub-item  
(photo to sub-photo)
* Operations on collections of data items
    * Operations that select a part of a collections(subset)
    * Operations that combine two collections(like tree combine)
    * Operations that compute a function on a collection(count)

Efficiency of Data Operations
* Measured by time and space
* Should use parallelism


### Data Scalability and Security

Achieving Scalability
* Vertical Scaling(Scale-up):
    * Adding more processors and RAM, buying a more expensive and robust server
* Many operations perform better with more memory, more cores
* Maintenance can be difficult, expensive

Scaling up and Scaling Out
*　Horizontal Scaling(Scale-out):
    * Adding more, possibly less powerful machines that interconnect over a netwrk
* Parallel operations will possibly be slower
* Easier in preactive to add more machines


The Server industry has many solutions for scale-up/scale decisions

Keeping Data Secure
* Data security- a must for snesitive data
* Increasing the number of machines leads to more security risks
* Data in transit must be secure
* Encryption and decryption increase security but make data operations expensive

---

## Real Big Data Applications

Energy Data Management Challenges at ConEd

The big data issue
* Not only big and fast
* Life-Cycel deadline
* Estimating the need for parallel and distributed computing

Gaming Industry Data Management: Q&A with Apmetrix CTO Mark Caldwell
> QA about big-data in Gaming industry


Flight Data Management at FlightStats: A Lecture by CTO Chad Berkley
* 500 sources of data
* Datapipeline
 ![](https://i.imgur.com/WxyTuM9.png)
     * Data processing engine is most of the nusiness logic happens
 * Hub
    * Object storage based, scalable, hightly available, multi-channel data queuing and eventing system.
    * Open course
    * ![](https://i.imgur.com/EG4Y90N.png)
* Data Warehouse
* Resources hosted in our private data center and with Amazon Web Services(AWS)
    * COre data processing and service layer resides in the private data cneter
    * API endpoints that require low latency connections live in AWS
* Private infrastructure virtualized with VMWare
* Engineering Principles
    * Agile development
        * Small, fast teams
        * Product centric
        * Customer interactive
        * Semi-autonomous
    * Automate everything
    * Measure everything
    * Total system awareness
    * Industry best practices and tools
    * Recruit and hire the best talent
* Software Stack
    * Java 8 backend
    * Node.js micro-service edge layer
    * PostgreSQL, MongoDB
    * Web - HTML5, React, Redux, Elasticsearch
    * Mobile- iOS/Android

---

# week2

## Data Model

Structure
```
Person{
    firstName:string,
    lastNme:string,
    DOB:date
}
```
Operations: eg:All DOB before 1990
Constraints:Today's Data 'minus' DOB must be greater than 18 years.

### Operations

* Subsetting
    * Example:Given a collection of data, and a condition
        * Find a subset of data from the collection so that each element in the subset satisfied
* Substructure extraction
    * Given a data collection with some structure, extract from each data item a part of the strucutre as specified by a conditon
* Union
    * Given two data collections, create a new one with elements of the two input collections
    * Duplicate elimination
* Join
    * Givent two data collections, create a new one with elements of the two iuput collections
    * Duplicate elimination

## Data Model Constraints

* Constraints are logical statements that must hold for data
    * A move has only one title
* Diffferent data models have dirrerent ways to expresss constraints

Types

* Value constraint
    * Age is never negative
* Uniqueness constraint
    * A movei can have only one title
* Carinality constraint
    * A person can take between 0 and 3 blood pressure medications at a time
* Type constraint
    * Last Name is alphabetical
    * Lname:string, not(isNumberic(Lname))
* Domain constraint
    * Day in(1...31)
    * Month in (1...12)or Monthin('Jan','Feb',...'Dec')


Structural Constraints

* A structural constraint puts restricitons on the structure of the data reather than the data valures themselves

---

oocalc : Spreadsheet application
If the CSV file had millions or more rows,then we could not import it into a spreadsheet. In this case, we would need a Big Data system such as Hadoop to analyze the data.

![](https://i.imgur.com/QL9i2pT.png)

---

Different kinds of Data Models

## Relational Data Model (one of simplest and most frequently used)

* relational tuple:represented as a row in the table
* Atomic: represent one unit of information and cannot be decomposed further
* No Duplicates
* Dissimilar tuples disallowed
* Relational Schema
* Foreign Keys
    * EmpSlaries.EmpID(Foreign Keys) References Employees.ID(Primary key)
* Joining Relations
    * Natural Join
    * one of most expensive(time and space) operations

### Semi-structured Data Model

HTML eg:`<html></html><p></p>`
mulitple list items
different number of them
means flexible

XML
Allows the querying of both schema and data

JSON

Tree Data Strucuture
![](https://i.imgur.com/48OFICp.png)

Tree Operations
* Paper
    * getParent>Document
    * getChildren>title, author, source
    * Getsibling>report
* Video database
    * Root-to-Node path
        * document/report/author/video database
* Queries need tree navigation
    * Auoth of XML query data model

---

Hands-on

Filter rows in the data
=average(
=sum(

json file
nested structure
extract data

Array Dta Model of an image
eog

Sensor Data
---

# week3
Different Kinds of Data Models Part2

### Vector Space Model

Document Vector: term frequency matrix
Inverse document frquency: $log_2$ 
> No reasons, more of a convention in many areas of Computer Science

Why IDF?
> In news, should "is" have more importance than "election"?

Using IDF penalized words that are too commonplace in the collection

![](https://i.imgur.com/zaSQTBh.png)

Searching in Vector Space

query>q: new new york
* Max frequency of a term("new") = 2
* Create the query vector
* A similarity function between to vectors is a measure of how far they are apart

Similarity Function
* Many possible functions
* Cosine distance

Query Term Weighting
* Every query term may optionally be associated with a weighting term
    * Multiply the query vector with these weights
    * Changing rank

Unstructure data
Image Search
RGB: feature vector
Similar vectors can be computed of the image texture, shapes of objects and opthers.

## Graph Data Model

### Spocal Network
> Graph represents the characters' allegiances

Data+Connectivity
* Property Graph
* Vertex Table
* Edge Table

Path
>Even without looking at the properties of the nodes and edges, one can get very intersting informations just by analyzing or querying this connectivity structure

Traversal
> involves edge following based on some sort of conditions

"Optimal Path" Operations
* Find the shortest path between two nodes
* Find an optimal roun-trip path that must include some specific nodes
* Find "best compromise" paths between nodes
    * Pareto-optimality

Neighborhoods

Communities
* A subgraph of a graph that has many more edges within the subgraph compared to edges to nodes outside the subgraph
* Operations
    * Dense subgraph finding
    * Optimaization of clusteredness

Anomalous Neighborhoods
* Near star
* Near clique
* Heavy vicinity
* Predomainant Edge

Connectivity Operations
* Connectedness Everynodeis reachable from each node in the undirected version of the graph

## "Other" Data Models

### Array as a Data Model
Array > Indexed realtion
Table representation
* Number of columns = number of dimenstions+1
    * eg:2 dims = 3 columns : rows, columnsm, values
    * Number of tuples = size of dimension 1 x size of dimenstion 2 x ...

Arrays of Vectors

Operaions on Arrary of Vectors
* dim(A)
* size(A, dim)
* A(i,j)
* A(i,j)[k]
* length(A(i,j))
* distance(A(i,j),A(k,l),f)- distance function f

---
Hands on
Exploring the Lucene Search Engins's Vector Data Model
* Index text and query
* Query with weighted terms, or "bootsting"
* Show Term Frequency-Inverse Document Frequency(TF-IDF)

Exploring Graph Data Models with Gephi
Average Degree, Connected Components, 
layout
* Force Atlas : group strongly components
* Fruchterman Reingold : equally space

---

# Week 4

### Data Model vs Dta Format
eg: CSV doesnt mean relational.(Data model is the same although the format is still CSV)

## Working with Streamning Data

Social Media
* Sales Trends
* Sales Disrebution
* Data-Driven Marketing

Internet of things>Moniorting and Fault Detection

Data Stream: Apossibly unbounded sequence of data records
Each data is generally timestamped and some cases Geo-tagged


Synchronized sequence of events

Data Streams>Streaming Data System
* Manage one record or small time windor
* Near-real-time
* Independent computaitons
* Non-interactive
> many challenges


Dynamic Steering
> is often a part of streaming data management and processing
> self-driving car

Some Streaming Data Systems:
Amazon Kinesis, APACHE Storm, Flink, Spark, Kafka

### Why is Streaming Data different?

Data-at-Rest
* Mostly static data from one or more sources
* Collected prior to analysis (analysis happens after collected)

Data-in-Motion
* analyzed as it is generated
    * eg:snesor data from self-driving vehicles
* Stream Processing

Data Processing Algorithms
* Static/Batch Processing
    * Size determines time and space
* Streaming Processing
    * Unbounded size, but finite time and space

Streaming Data Management and Processing
* Compute one data element or a small window of data elements at a time
* Relatively fast and simple computations
* No interaction with the data source

Lambda Architecutre

Streaming Data Changes Over Time
Size + Frequency

Changes can be periodic or sporadic

Summary
Size>unbounded
Size and Frequency>Unpredicatable
Processing>Fast and Simple


### Data Lakes

Data lake is a part of abig data intfrastructure that many streams can flow into get sotred for processing in their original form


schema on read
Load data from source>Store raw data>Add data model on read


Scheam-on-Write Approach

Data Warehouse>Schema-on-write>Transform and strucutre before load

Data WArehouse:Hierarchical File System
Data Lake:Object storage

Data Lake Object Storage
each data is stored as binary large object or BLOB ans is assigned a unique identifier.
each data object is tagged with a number of metadata tags, data can besearched using these metadata tags to retrieve it.

Data Lakes Summary
* A big Data Sotrage Architecture
* Collects all data for current and future analysis
* Transform data format only when needed
* Supports all types of big data users
* Infrastructure components which evolve over time based on apllication-specific needs

---

hands-on : Handling Data Streams
plotting real-time data

Streaming Twitter Data

---

# Week 5 Why Data Management?

database management system

### DBMS-based and non-DMBS-based Approaches to Big Data

Storing Data-Files vs DBMS
* In the old times, database operations were applications in file sysyems
* Problems
    * Data redundancy, inconsistency and isolation
    * Each task a program(no uniform way)
    * Data integrity(constraints)
    * Atomicity of updates

Advantages of a DBMS
* Declarative query languages
    * No more task-based programs
* Data independence
    * Applications dont worry about data storage formats and locations
* Efficient access through optimization
    * The system automatically finds an efficient way to access data
* Data integrity and security
    * Methods to keep accuracy and consistency of data despite failure
        * ACID properties of transactions
            * Four thing transactions(operation) should provide
                * Atomicity
                    * data written to DB must valid according to all defined rules including constrains
                * Consistency
                * Isolation
                * Durability
                    * ensures that once a transaction has been committed, it will remain so, even in the event of power loss, crashes or errors
        * Failure recovery
* Concurrent access 
    * Many users can simultaneously access data without conflict
    * Guaranteed by the isolation property


Parallel and Distrbuted DBMS
* Parallel databese system
    * Improve performance throught parallel implementation
    * Often allows data replication
        * Data redundancy against table corruption
        * More concurrent queries
* Distributed database system(not much in this course)
    * Data is stored across serveral sites, each site managed by a DBMS capable of running independently
> Does ur big data problem need these facilities?(many case negative)

DBMS and MapReduce-style Systems
* Started with a different problem focus
    * DBMSs:efficient storage, transactions and retrieval
        * Partitioned data parallelism
        * Account for computtiaon and communication cost
        * Not node failure
    * mapreduce-style systems:complex data processing over a cluster of machines
        * HDFS-based
        * Analytic-data mining, clustering, machine leraning
        * Multi-stage, problem-specific algorithms
        * Operate on wider variety of data including text

Shfiting Requirements
* Data loading- a new bottleneck
    * Does the application need data sooner thne the loading time?
* Too much functionality
    * Does the applciation use only a few data management features?
* Combined Transactional and Analytical Capabilities

No Single Solution
* Mixed solutons
    * DBMS on HDFS
        * Hadoop-DBMS interoperation
    * Relational operations in MapReduce systems like Spark
    * Streaming input to DBMS
    * New paralle programming models for analytical computation within DBMS


## From DBMS to BDMS
Big Data Management System

Desired Characteristics of BDMS
* A flexible, semistructured data model
    * "schema first" to "schema never"
* Support for today's common "Big Data data types"
    * Textual, temporal, and spatial data values
* A full query language
    * Expectedly at least the power of SQL
* An efficient parallel query runtime
* Wide range of qeury sizes
* Continuous data ingetstion
    * Stream ingestion
* Scale gracefully to manage and query large volumes of data
    * Use large clusters
* Full data management capability
    * Ease of opertional simplicity

### ACID and BASE
* ACID properties hard to maintain in a BDMS
* BASE relaxes ACID(and replace)
    * BA:Basic Availability
    * S:Soft State
    * E:Eventaul Consistency(while stop recieving input)
        * 範例:Facebook的朋友更新內容,未必能馬上看見
    
CAP Therorem
* A distributed computer system cannot sumultaneously achieve
    * Consistency
        * all nodes see the same data at any time
    * Availability
        * guarantee that every request receives a response about whether it succeeded or failed
    * Partition Tolerance
        * The System continues to operate despite arbitrary partitioning due to network failures


The Marketplace
![](https://i.imgur.com/D0yMdmH.jpg)

---

### Redis - An Enhanced Key-Value Store
* In-memory data strucure store(very fast)
    * strings, hashes, lists, sets, sorted sets
* Look-up Problem
    * Case 1:(key:string, value:string)
        * small images can be used as binary string keys
    * Keys may have internal structure and expiry
        * comment: 1234: reply.to
        * Hierarchical keys:user.commercial, user.commercial.entertainment, user.commercial.entertainment.move-industry
    * Case2:(key:string, value:list)
        * userID:[tweetID1, tweetID2]
        * Ziplists compress lists
            * compacts the size of the list in memory without chaning the content
        * Twitter innovation: list of ziplists
            * gavei the flexibility of having constant timing insertions and deletions and at the time used the compressed representation to save space
    * Case3:(key:string, value:attrebute-value paris)
        * REDIS Hashes
            * std:101 name"John Smith" dob:01-01-2000 gender:M active:0 cgpa:2.9
            * std:101 (5) is associated with five attributed value pairs
            * retrieval is efficient



### Redis and Scalability

* Partitioning and Replcation
    * Range partioning
        * EG:User record number 1-10000 goes to machine1, 10001-20000 goes to machine 2
    * Hash partioning
        * Pick a key of a record
        * Using a hash function, turn it into a number
        * 152 mod 10 is 2, so the record goes to machine 2
    * Partitioning and Replcation
        * Master-Slave mode replication
            * Clients write to master, master replcaites to slaves
            * Clients read from slaves to scale up read performance
            * Slaves are mostly consistent

---

###  Aerosplike : a New Generation KV Store

which calls itself a distributed NoSQL database and key value store, provide the performance needs of today's web scale applications


![](https://i.imgur.com/jM6D5JR.png)


Fast Path


![](https://i.imgur.com/907xnDo.png)

Secondary index fields that are non-primary keys, which is a key attribute that makes a tuple unique, but it has not been chosen as a primary key

Secondary indices are stored in main memory
Built on every node in a cluster and co-located with the primary index
Each secondary index entry contains references to records which are local to the node

### Querying Aerospike

* Data types
    * Standard scalar, lists, maps, geospatial, large objects
* KV store operations
    * Geospatial queries like point-in-polygon
* AQL: an SQL-like-language
    * SELECT name, age FROM users.profiles

Transactions in Aerospike
* Aerospike ensures ACID
    * Consistency-all copies of a data item are in sync
        * Uses synchronous write to replicas
        * Mechanisms to relax immediate consistency
    * Durability
        * Flash storage
        * Replication management
    * Network partitioning reduced
        * Tighter cluster control

> But does that just contradict the CAP theorem?
> That means when nodes in different parts of the network have different data content
> Aerospike reduces and tries to completely eliminate the situaion by making sure that the amster know exactly where all the other nodes are. And the replication is happening properly even when the new nodes are joining the network

---

## Semistrucured Data - AsterixDB

MongoDB: JSON stlye semi-structured data
AsterixDB is similar and newer
Provides ACID guarantees

```
create type TwitterUserType as open{
...
}
```
open means that the actual data can have more attributed than specified here.(contrast: closed)

create dataset TweetMessages(TweetMessageType)
primary key tweetid;


### Options for Querying in AsterixDB
it has own query language called the Asterix query language which resembles the XML credit language query

AsterixDB has creative processing engine that can process queries in multiple langauage

* AQL is a natively-supported query languagee
* Hive queries
* Xquery
* Hadoop MRjobs
* SQL++(coming up)

### Operating Over a Cluster

* Hyracks
    * Query execution engine for partitioned parallel execution of queries
    
* Hyracks Job Management

### Accessing External Data

Real-time data from files in a directory path or an external API

---

## Solr - Managin Text

* Basic challenges with text
    * Defining a match
        * Analyze $\approx$ Analyzse $\approx$ ANALYZE ?
            * Lexical difference, capitalization
        * abc:def-230-39 $\approx$ abcdef23039 ?
            * Structural punctuations
        * "Barak Hussein Obama" $\approx$ "Barak Obama" $\approx$ "Barak H. Obama" $\approx$ "B.H. Obama"?
            * Nominal Variations
        * Mom $\approx$ mother?
            * Synonyms
        * Dr. $\approx$ Doctor
            * Abbreviation
        * USA $\approx$ "United States of America" 
            * Initialism
        * "The tradition is completely American. Students should ..."
            * Should this match the query "American students"?
                * Shouldn't
        * "Mrs. Clinton also said ..."
            * Should this match the query "mrs Clinton"
                * Should


### Inverted Index
* Vocabulary
    * All terms in a collection of documents
        * Multi-word terms, synonym sets
* Occurrence
    * For each term in the collection
        * Inverted index
            * List of doc ID
            * List of doc ID, [position of occurrence]
        * Other statistic like tf, idf
            
### Solr Functionality
* Enterprise Search Platform
* Inverted index
    * For every field in a strucutured text document
        * indexes text, numbers, geographic information, ...
* Faceted Search
* Term hightlighting
* Index-time Analyzers
    * Tokenizers
        * The precess of breaking down the cahracters read
    * filters
* Query-time Analyzers

### Solr Queries
* Consider the CSV file
* All books
    * http://localhost:8983/solr/query? q=*.*
* All books with "black" in the title field, return author, title
    * http://localhost:8983/solr/query? q=title:black&fl=author,title
* ......

---

## Relational data - Vertica - a Columnar DBMS
* Column Store
    * Store data column-wise
    * A queery only uses the columns needed
    * Usually must faster for queries even for large data

Space Fiificiency
* Column stores keep columns in sorted order
* Values in columns can be compressed
    * Run-length encoding
        * 1/1/2007 - 16 records
    * Frame-of-reference encoding
        * Fix a number and only record the difference
* Compression saves storage space

### Working with Vertica

* Column-Groups
    * Frequently co-accessed columns behave as mini row-stores within the column store
* Updata performance slower
    * Internal conversion from row-representation to  column-representation
* Enhanced suite of analytical operations
    * Window statisitcs
        * Ticks(ts TIMESTAMP,Stock varchar(10)),Bid float

### Vertica and Analytic Functions
### Vertica and Distributed R
* Distributed R
    * High-performance statistical analysis
    * Master node:schedules tasks and sends code
    * Worker nodes: maintain data partitions and compute
    * Uses a data strucutre called dArray or distributed array

Load data from Vertica/HDFS/Local FS > 
Optionally add additional data using Idol-on-demand APIs > 
Train mode using Random Forest in Distributed R > 
Deploy model to Vertica or as a web service



---


Designing a Data Model for 'Catch the Plink Flamingo'


1.Primary Key: userID.
2.Coumn teamID as a foreign key references to Teams table.


userID: long	sessionID: long	timestamp:       dateTime	clickedPoint: coordinate	missionID:    int	isHit:   boolean	teamID:               long
100	4356	10/12/2015::14:15:09	(4,8)	13	yes	10000
101	3241	10/23/2015::14:15:19	(20,5)	18	no	10100
102	4537	11/4/2015::14:15:20	(17,43)	21	no	10100


Node table
ID             	Property(N)					
1	User					
2	Chat Session					
3	Chat text					

Edge table
Srcld	Dstld	Property(E)				
1	2	leaves				
1	2	joins				
1	2	starts				
1	      3        	writes				
2 	      3	contains				
3	      1	mentions				

	
					

1. Counting when Node-User writes to Chat Text.

2. Check Chat Text for timestamp about the User leaving team when Chat Session receive leaves.

3. Joins.

4. Count userID when Chat text mentions back to users within a specific time period

5. Calculate and record in Node-User when join or leave Chat Session.


Structure:
flamingo(flamingos) -> flamingo species(flamingo-type) -> flamingo with shapes(flamingo-subtype) -> eye-color(flamingo property)


 flamingo species: greater flamingo, lesser flamingo, Chilean flamingo, ...
flamingo with shapes: with stars, with circles, with triangles, ...
eye-color: red, black, blue, green, brown, ...

---

## Summary

* Data model tells you
    * How ur data is strucutured
    * What operations can be done on the data
    * What constraints apply to the data
* Database Management Systems
    * Tpyically handlle many low-level details of data storage, manipulation, retrieval, transactional updates, failure and security
    * Relieves a user to focus on higher level operations like querying and analysis
* Relational Data
    * Where data look like tables
* Semi-strucutred Data
    * Document data, XML and JSON
* Graph Data
    * Social Networks, email networks
* Text Data
    * Articles, reports
* Streaming Data
    * An infinite flow of data coming from a data source
        * Sensor data from instruments
        * Stock price data
    * Data rates vary- can be too fast and too large to store
    * Often processed in memory
    * May need to be processed immediately
        * Inform whenvevr 3 tech stocks go up by 3% within a 30 second span
        * Use for event detection and prediction


DBMS and BDMS
* BDNS
    * Desugbed for parallel and distributed processing
        * Data-partitioned parallelism
    * May not alwasy guarantee consistency for every update
        * More likely to guarantee eventual consistency
    * Often built-on Hadoop
        * Offer Map-reduce style computation
        * Utilizes replication natively offered by HDFS

###### tags: `Big Data`








