Big Data Integration and Processing
===

# Week1 
Why Big Data Inegration and Processing?

* Supprot Big Data Operations
    * Split volumes of data
    * Access data fast
    * Distribute computations to nodes
* Handle Fault Tolerance
    * Replicate data partitions
    * Recover files when needs
* Enable Adding More Racks
* Optimized and extensible for many data types
* Enable both streaming and batch processing
    * Low latency processing of streaming data
        * Latency is quantification of the delay in the processing of the streaming data in the system
        * Hadoop for instance is not a great choice for operations that require low latency
    * Accurate processing of all available data

Volume: Scalable batch processing
Velocity: Stream processing
Variey: Extensible data storage access and integration

---

##  Querying Data 
### Data Retrieval
* Data retrieval
    * The way in which the desired data is specified and retrieved from a data store
* Our focus
    * How to specify a data request
        * For static and streaming data
    * The internal mechanism of data retrieval
        * For large and streaming data
### Query Language
* A language ot specify the data items u need
* A query language is declarative
    * Specify what u need rather than how to obtain it
    * SQL(Strucutred Query Language)
* Database programming language
    * Procedural programming language
    * Embeds query operations

SQL
* The standard for strucutred data
    * Oracles'sSQL to Spark SQL
    
SELECT-FROM-WHERE

### Select-Project Queries in the Large


A tuple is a sequence of immutable Python objects. Tuples are sequences, just like lists. The differences between tuples and lists are, the tuples cannot be changed unlike lists and tuples use parentheses, whereas lists use square brackets. Creating a tuple is as simple as putting different comma-separated values.


* Large Tables can be partitioned
    * Many partitioning schemes
        * Rangepartitioning on primary key
* Tow queries
    * Find records for beers whose name starts with 'Am'
        * SELECT * FROM Beers WHERE name like 'Am%'
    * Which beers are mad by Heinken?
        * SELECT name FROM Beers WHERE manf = 'Heineken'
    * A query processing trick
        * Use the partitioning information
            *Just use partion 1
            
Broadcast query- In each machine in parallel"Select manf= 'Heineken'(Beers) > Gather aprtial Results > Union > Return

Local and Global Indexing
* What if a machine does not have any data for the query attributes?
* Index strucutres
    * Given value, return records
    * Several solutions
        * Use local index on each machine
        * Use a machine indexe for each value
        * Use a combined index in a global index server

### Queruing Two Relations
* Often we need to combine two relations for queries
    * Find the beers liked by drinkers who frequent THE Great A,merican Bar
* In SQL
    * SELECT DISTINCT beer 
    * FROM Likes L, FrequentsF
    * WHERE bat = 'The Great American Bar'AND
        * F.drinker = L.drinker
* SPJ Queries (Select-Project-Join)
    * Steps
         Selection bat = `The Great American Bar`(Frequents)
         Join F.drinker = L.drinker(_, Likes)
         Project beer(_)
         Deduplicate(_)
         Output

Underscores "_" are plcaeholders for the part of the input that comes from the previous step in the pipeline


### Join in a Distributed Setting
* Semi-join
    * A semijoin from R to S on attribute is used to reduce the data transmission cost
    * Coputing steps:
        * ==Project== R on sttribute A and call it(R[A]) - the Drinkers column
        * ==Ship== this projection (a semijoin projection)from the site of R to the site of S
        * ==Reduce== S to S' by eliminating tuples where attribute A are not matching any value in R[A]

Dont need to understand this graph.
However, if we werer to implement a similar operation and all that u have is Hadoop, u may end up implementing this kind of algorithm urself.

![](https://i.imgur.com/TGpfkxD.png)

### Subqueries

* A slightly complex query
    * Find the bars that serve Miller for the same or less price than what TGAB charges for 
* We may break it into two queies
    * 1.Find the price TGAB charges for Bud
    * 2.Find the bars that serve Miller at that price

in SQL
```SQL
    SELECT bar
    FROM Sells
    WHERE beer = 'Miller' AND
        price <= (SELECT price
                  FROM Sells
                  WHERE bat = 'TGAB'
                  AND beer = 'Bud')
```
> in the "()" The price at which TGAB selss Bud
> subquery is uncorrelated


### Subqueries with IN
* Find the name and manufacturer of each beer that Fred does not like
* Query
```SQL
    SELECT*
    FROM Beers
    WHERE name NOT IN
                (SELECT beer
                 FROM Likes
                 WHERE drinker = 'Fred');

```

### Correlated Subqueries
* Find the name and price of each beer that is more expensive than the average price of beers sold in the bar
```SQL
SELECT beer, price
FROM SElls s1
WHERE price>
        (SELECT AVG(price)
         FROM Sells s2
         WHERE s1.bar = s2.bar)
```

### AGGregate Queries
Find the average price of Bud
```SQL
SELECT AVG(price)
REOM Sells
WHERE berr = 'Bud';
```

Other aggregate functions
SUM, MIN, MAM, COUNT, ...

### GROUP BY Queries
Find for each drinker the average price of Bud at the bars they frequent
```SQL
SELECT drinker, AVG(price)
FROM Frequents, SElls
WHERE beer = 'Bud' AND
    Frequents.bar = Sells.bar
GROUP BY drinker;
```

---

Querying Relational Data with Postgres

---


# Week2

Querying JSON Data with MongoDB

### SQL SELECT and MongoDB find()
* MongoDB is a collection of documents
* The basic query primitive
    * `db.collection.find(<query filter>,<projection>).<cursor modifer>`
        * collection: like FROM clause, specifies the collection to use
        * query filter: Like WHERE clause, specifies which documents to return
        * projection: Projection variables in SELECT clause
        * cursor modifier: How many results to return etc.


SQL vs MongoDB
`SELECT*FROM Beers`
db.Beers.find()

SELECT beer, price FROM Sells
db.Sells.find(
    {},
    {beer:1,price:1}
)
empty query condition
1 if an attribute is output and 0 if its not
Every MongoDB document has an identifier named_id
You should explicitly say, _id:0 if u dont want to return

### Adding Query Conditions


`SELECT manf FROM Beers WHERE name = 'Heineken'`
`db.Beers.find({name:"Heineken"}, {manf:1,_id:o})`


`SELECT DISTINCT beer, price FROM Sells WHERE price > 15`
`db.Sells.distinct({price:{$gt:15}},{beer:1,price:1,_id:o})`


![](https://i.imgur.com/FxTr1lI.png)


### Regular Expressions


Count the number of manufactures whose names have the partial string "am" in it - must be case insensitive
`db.Beers.find(name:{$regex:/am/i}).count()`


Same, but name starts with "Am"
`db.Beers.find(name:{$regex:/^Am/}).count()`

Start with "Am" ends with "corp"
`db.Beers.count(name:{$regex:/^Am.*crops$})`


### Array OPerations
* Find items which are tagged as "popular" or "organic" 
    * db.inventory.find({tags:{$in"["popular,"organic]}})
* Find items which are not tagged as "popular" nor "organic"
    * db.inventory.find({tags:{$nin:["popular,"organic"]}})
* Find the 2nd and 3rd elements of tags
    * db.inventory.find({},{tags:{$slice:[1,2]}})
        * 1:Skip count 2:Return how many
    * db.inventory.find({},tags:{$slice:-2})
        * The minus says that the system should count from the end and two says that it should txtract two elements
* Find a document whose 2nd element in tag is "summer"
    * db.inventory.find(tags.1:"summer")

### Compound Statements
```MongoDB
db.inventory.find({
    $and:[
      {$or:[price:3.99],{price:4.99}},
      {$or:[{rating:good},{qty"{$lt:20}}]}
      {item:{$ne:"Coors"}}
    ]
})
```

```SQL
SELECT * FROM inventory
WHERE((price=3.99)OR(price=4.99))AND
    ((taing="good")OR(qty<20))AND
      item!="Corrs"
```

### Queries over Nested Elements

* db.suers.find({'points.0.points':{$lte:80}})

points.0.points refers to the first element of that tuple

* db.user.find({'points.points"{$lte:80}'})

without specifying the array index

* db.user.find({"points.points":{$lte:81},"points.bonus":20})

comma is treated as an implicit and condition within the same double, as show in the first "{}"


MongoDB does not have adequate support to perform recuresive queries over nested substructures

## Aggregation Functions

### On Counting and Distince
* Count the nubmer of Drinkers
    * Select count * from Drinkers
    * db.Drinkers.count()
* Count the number of unique address of Drinkers
    * Select count(distinc addr) from Drinkers
    * db.Drinkers.count(addr:{$exists:true})
        * If an affress exists for a drinker, it will be counted
* Get the distnct values of an array
    * Data:{_id:1,places:[USA,France,USA,Spain,UK,Spain]}
    * db.countyrDB.distinct(places)
        * [USA,France,Spain,UK]
    * db.countryDB.distinct(places).length
        * 4

### Aggregation Framework
* Role of aggrgation framework
    * Grouping, aggregatae functions, sorting,...

![](https://i.imgur.com/Hyk7DLz.png)


### Multi-attrtibute Grouping

```MongoDB
db.computers.aggregate(
  [
    {
    $group:{
       _id:{brand:"$brand",title:"$title",category:"$category",code:"$code"},
       count:{$sum:1}
     }
    }
    {
    $sort:{count:1,category:-1}
    }
  ])

```
> The first is a computed ocunt variable in ascending order
> The next sorting attribute is secondary, if two groups have the smame value for count then they'll be further sorted based on the category value.
> But this time the order is descending bucuz of the -1 direcitve




### Text Search with Aggregation

```MongoDB
db.articles.aggregate(
 [
  {$match:{$text:{$search:"Hillary Democrat"}}},
  {$sort:{score:{$meta:"textScore"}}},
  {$project:{title:1,_id:o}}
 ]
)

```

> $match directive of the aggregate function must be told its goin to perform a text function on the article's corpus
> The actual text function is $search
> set search terms like "Hillary Democrat" satisfy the requirement
> As is the case of any text engine
> Results of any search returns a list of documents, each with a score
> Next task is to tell MongoDB to sort the results based on textScore
> Meta stands for metadata that is additional information
> Any step in the pipeleine can produce some extra data, or metadata for each processed document
> project: it tells the system to output only the title of each document





### Join in MongoDB

MongoDB introduced this quuivalent of join only in version 3.2

```MongoDB
db.orders.aggregate([
 { $lookup:  {    
     from:"inventory",
     localFiled:"item",
     foreignFiels:"sku",
     as:"inventory_docs"
  }
])
```

>last item as: is a construction part of the join operation which says how to strucutre the match items into the result

> It matches documents and inventory where the sku item is also null


## Querying Aerospike

Key value sotre offer API
The way to access data using a programming language
Aerospike offers both a programmatic access and a limited aomunt of query access to data


name space contains records, indexes, policies

policies dictate name spce behavior like how data is stored, RAM/disk, how many replicas exisr for a recor, when records expire

A name space can contain sets(think of tables)
Within a record, data is stored in one/many bins
Bins consist of name and a value

JAVA
```java
return client.createIndex(policy, "example", "tweet", "Test Index", "user_name", IndexType.STRING);
```
> name of the index : Test Index
> name of the bin : user_name

```Java
Key key = new Key("example," "tweet", st.getID());
Bin tweeID = new Bin("userID", st.getUser().getID());
Bin userName = new Bin("user_name", st.getUser().getScreenName());
client.put(pm, key, tweet, userName)

```

Data be inserted into Aerosppike programmatically

Key in the namespace call example, and set call tweet, is the value of the function getID which return the ID of a tweet

When data is populated, creating bins
user)name is the attribute and screen name obtained from the tweet is the value


actully insertion happen in client
inseting two bins at a time:idiosyncrasy of Aerospike

### Querying Fast Data

The query defines a window to select key of these data objects as a unit of processing

![](https://i.imgur.com/ATZp64b.png)


Slide of the window - from window 1 to 2 : 2 movement

`SELECT Distinct vehicleID From PosSpeedStr [Range 30 Esconds]`

Streaminig data results in changes in both the query langauge and the way queries are processed.

---

## Hands on 
`./mongodb/bin/mongo`
`show dbs`
We can see what databeses ara available in the MongoDB server

switch to db sample : `use sample`

db.users.find({user_name : "ActionSportsJax"})
> but looking bad

db.users.find({user_name : "ActionSportsJax"}).pretty()

db.user.find({user_name: "ActionSportsJax"}, {tweet_ID:1, _id:0})

db.user.find({tweet_text: /FIFA}/).count()


A text index can be created to speed up searches and allows advanced searches with $text. 

The argument tweet_text specifies the field on which to create the index.


`db.users.createIndex({"tweet_text:"text"})`

`db.users.find({$text:{#earch:"FIFA"}}).count()`

not containing a specific value

db.users.find({$text:{$search:"FIFA -Texas"}}).count()

db.users.find({tweet_mentioned_count: {$get : 6}})

The $gt operator search for values greater than a specific value. We can use the $where command to compare between fields in the same document. For example, the following searches for tweet_mentioned_count is greater than tweet_followers_count:

db.users.find({$where : "this.tweet_mentioned_count > this.tweet_followers_count"}).count()

 the field names for $where are required to be prefixed with this, which represent the document.
 
 
`db.users.find({$and : [{tweet_text : /FIFA/}, {tweet_mentioned_count: {$gt : 4}}]}).count`

## Exploring Pandas DataFrames
jupyter notebook instead of pyspark
> pyspark 開啟 import pandas 會有error
 
buyclicksDF = pandas.read_csv('buy-clicks.csv')
buyclicksDF[['price', 'userID']].head(5)
buyclicksDF[buyclickDF['price']<3].head(5)
buyclicksDF['price'].sum()  (.mean())
mergeDF = adclicksDF.merge(buyclicksDF, on='userID')

quiz:
g[g['teamLevel']==8].count()
m[(m['price']==20) & (m['teamLevel']==8)].count()


---





# Week3
## Information Integration
### Overview of Infomation Integration

### Integrated Views
The relation which is derived that is computed by querying two different data sources and combining their results, is called an integrated view.
It's integrated because the data is retrieved from different data sources and its called a view becuz in database terminology, its a relation computed from other relations.

### Schema Mapping


![](https://i.imgur.com/qBZlk5E.png)


### Querying Integrated Data

* Find the bank account number of a person whose plicyKey is known
    * SELECT AcctNumber FROM discountCandidates where policyKey = '4-937528734'
> but how the query be evaluated?
> That depends on whats called the query atchitecutre of the data integration system

![](https://i.imgur.com/872JaMd.png)

* Z:wheter we have one data source or multiple data sources
* X:asks whether integrated data is actually stored physically or whether its computed on the fly(? cloud?), each time a query is asked.
    * All precomputed and sotred - materialized
    * Computed on the fly - virtual
* Y:Asks whether there is a single schema or global schmea defined all over the data integrated for an application or whether the data stay in different computers and its accessed in a peer-to-peer manner at runtime.


### Record Linkage

Goad of an information integration system is to be complete and accurate.
* Complete means no eligible record from the source should be absent in the target relation.
* Accurate means all the entries in the integrated relation should be correct.


2 record manybe looking different(different person)
* 可能因為嫁人 全名有所不同
* manybe changed the social media
> This is called a record linkage problem.

Solution:perhaps 
* by clustering the values of different attributes
* by using a set of matching rules
* eg: determine which of the addresses should be used in the integrated relation.
    * if answer is both, need to change the scema of the target's relation to a list instead of an atomic number to avoid creating multiple tuples for same entity

### The "Big Data" Problem

* Many sources
    * Hundreds of tables
    * Schema mapping problem is a combinatorial challenge
* (tackle this problem)Pay-as-you-go model
    * Only integrate sources that are needed when needed
* (One approach to do this)Probabilistic Schema Mapping
    * detail next

### Deconstructing the Case - Hypothetically

* Customers - an integrated table
* Candidate designs
    * Create the customer table to include individuals and corporations  - use a flag called customer_type to distinguish. In the mediated schema
        * Individual(FN+MI+LN), PolicyHolder.Name, Corporations.Name map to Customer_Name
        * Names of two types of customers become two different attributes
        * Ind.FullAddress, Corp.RegisteredAddress, PH.(Address+City+State+Zip)map to Customer_Address
    * Issues
        * Should the DOB, Nationality, Legal Status be included in this table?

### Attribute Grouping

* How to evaluate if two attributes should go together?
    * How similar are the attributes
        * Individual names vs. policyholder names?
        * Individual names vs. Corporation names?
    * How likely is it that two attributes would co-occur?
        * Should the DOB put in the same schema as the individual name?
        * How about DOB and the corporation name?

### Customer Transactions

Comput pairwise attribute similarity and using a threshold plus/minus an error, put similar attributes in the same cluster.

For every subset of uncertain pairs create a mediated schema.


![](https://i.imgur.com/MGmc9gI.png)

### Probabilistic Mediated Schema
* Find source schemas that are consistent with a mediated schema
    * A source schema is consistent with a mediated schema if two different attributes of the source shema do not occur in a cluster
        * Med3({TID},{TBT,TDT},{TET,TDT}{TA+CD,A},{TP},{TD,TDT},{TT},{B},{P}) is better than
        * Med1({TID},{TBT,TET,TDT}{TA+CD,A},{TP,TD,TDT},{TT},{B},{P})
            * TBT & TDT
* Choose the k best mediated schema
    * hard to answer, all close
---

### A Data Integration Scenario
* 4 data sources each with one relation
    * S1:Treats(Doctor, ChronicDisease)
    * S2:Discharges(Doctor, Patient, Clinic)
    * S3:Treats(Docotor, ChronicDiseas)
        * Same as S1? totally possible, cuz sources are independent
    * S4:Surgeons(SurgeonName)
* Target schema
    * TreatsPatient(Doctor, Patient)
    * HasChronicDiseas(Patient, ChronicDisease)
    * DischargesPatientsFromClinic(Doctor, Patient, Clinic)
    * Doctors(DoctorName)
    * Surgeons(SurgeonName)

### Example Schema Mapping
* Local-as-View(LAV)mapping
    * Mapping source schemas to target schema
    * Easier to add sources


S1.Treats(d, s) -> TreatsPatient(d, p) AND HasCHronicDisease(p,s)
```
SELECT doctor, chronicDisease
FROM TreatsPatient T, HasChronicDisease H
WHERE T.Patient = H.Patient
```
> doctor, chronicDisea = d, s meationed in S1
> mentor only said this, no others.

S2.Discharges(d, p, c) -> DischargesPatientFromClinic(d, p, c)
S3.Treats(d,s) -> TreatsPatient(d,p) AND HasChronicDisease(p,s)AND Doctors(d)
S4.Surgeons(d) -> Surgeons(d)

### Query Answering
* Query
    * Which doctors are responsible for sidcharging patiemts?
    * SELECT DoctorName
    * FROM Doctors D1, DischargesPatientsFromClinic D2
    * WHERE D1.DoctorName = D2.DoctorName
* Query reformulation
    * Automatically transform query against the target schema to simplest qyert against source schemas
* Ideal Answer
    * SELECT Doctor
    * FROM S3.Treats T,S2.Discharges D
    * WHERE T.Doctor = D.Doctor
        * S3 Treats mean treats relation in sources 3
        * To find such an optimal query reformulation, it turns out that this process is very complex and becomes worse as a number of sources increases
        * Thus query reformulation becomes a significant scalability problem in a big data integration scenario


---

RIM which stands for Refrerence Information Model is global schema that this industry has developed and expects to use as a standart 

### Data Exchange

Given a source database with a finite number of relations, a set of schema mapping, and a set of constrains that the target schema must satisfy, the data exchange problem is to find a finite target database such that both the schema mappings and the target constraints are satisifed.

### Using Codebooks

* Logical Observation identifiers Names and Codes(LOINC) is a database and universal standard for identifying medical laboratory observations

### Using Compressed Data

* Compression
    * Encoded representation of data so that is uses less space
    * Dictionary encoding

> Important for Bid Data


### Ontological Data
* Ontology
    * A set of terms of a domain
    * Relationships between the terms
* SNOMED
    * A medical ontology used for clinical data

> Ontology queries are graph queries

### The Takeawau Points

![](https://i.imgur.com/WvkYe09.png)



* Integration across multiple data models
    * Globla Schema - RIM
    * Data Exchange
        * Format conversions
        * Constraints
        * Compressed Data
        * Model transformation
        * Query transformation

## Integration for Multichannel Customer Analytics

In short, they are on the Internet or in material received through the Internet


* Customer analytics
    * Processes and technologies that give organizations the customer insight necessary to deliver offerts that are anticipated , relevant and timely

* Questions one would like to ask
    * Is our product launch going well?
    * Is there an emergind product issue?
    * Where should the product team focus its development dollars?
    * Are these more effective methods for positioning current products?
    * Which servise have the best chance of surviving a turbulent market?
    * Is there a product defect in the market?

### Data Fusion

The goald of Data Fusion is to find the values of Data items from a source.

* Data sources
* Data items
    * value
        * A porduct
        * A part of a product
        * A feature of a product
        * The utility of product feature
        * ...
* Using data from a subset of sources find the true value or a true value distrubtion of a data item
* Assemble all such values for the real-world entity represented by the data items.

### Too Many Sources
* Too many sources = too many values
* Voting to select the "right" value
    * Simple voting can be problemmatic - Veracity problem
        * Source reliability
        * Copy Detection
    * Statisitcal techniques to estimate
        * Trustworthiness of sources
        * Bias introduced by copies
        * True distribution values for data items

### Source Selection
* The problem
    * Choose only useful sources
    * Adding sources first improves integration accuracy then reduces it
* Solution
    * Order candidate source based on a measure of "goodness"
    * Add sources until the marginal benefit is less than the marginal cost
    * Current techniques scale well

## Industry Examples for Big Data Integration and Processing

### Big Data Mangagement and Processing Using Splunk and Datameer

### Why Splunk?
### Connected Cars with Ford's OpenXC and Splunk
By using the OpenXC data, and by splunking that creating links in dashboards will give it to match ups and correlations.
### Big Data Management and Processing using Datameer

---

## Hands-on
Splunk accout name:tinghao
password:第一個大寫 最後需要特殊符號-


### Exploring Splunk Queries
source="census.csv" host="DESKTOP-84Q2B4H" sourcetype="csv"

STNAME="California" OR STNAME="Alaska"
STNAME="California" CENSUS2010POP > 1000000 | table CTYNAME, CENSUS2010PIP
> population > 1m

> Limit the results to one/more columns, adding pipe table CTYNAME to end of our query.
> In Spunk queries, the pip command is used to send the outputs from the first part of the query into the next.


STNAME="California" | stats count
STNAME="California" | stats sum(CENSUS2010POP)

### Optional: Creating Pivot Report in Splunk


### Quiz
Which of the queries below will return the average population of the counties in Georgia (be careful not to include the population of the state of Georgia itself)?

> source="census.csv" CTYNAME != "Georgia" STNAME="Georgia" | stats mean(CENSUS2010POP)


which query allows you to find the state with the most counties?
> source="census.csv" | stats count by STNAME | sort count desc

which query allows you to find the most populated counties in the state of Texas?
 
> STNAME="Texas" CENSUS2010POP > 100000 | sort -CENSUS2010POP | table CENSUS2010POP,CTYNAME
> or
> STNAME="Texas" CENSUS2010POP > 100000 | sort CENSUS2010POP desc | table CENSUS2010POP,CTYNAME



---

# Week4
## Big Data Pipelines and High-level Operations for Big Data Processing

dataflow graphs

Split -> Do Something -> Merge(like:reduce)
Represents a large number of applications

* pipeline
The term pipe comes from a UNIX separion that the output of one running program gets piped into the next program as an input 
* data parallelism
The parallelism of each step in the pipeline is mainly data parallelism. We can simply define data parallelism as running the same functions simultaneously for the elements or partitions of a dataset on multiple cores.


> There explain the same things at course 1

Advanced stream data from an online game
* ur event gets ingested through a real time big data ingestion engine
    * Kafka, Flume
* Then they get passed into a Streaming Data Platform for processing
    * Samza, Storm, Spark
> Any pipeline processing od data can be applied to the streaming data here as we worte in a batch-processing Big Data engine.

The process stream data can theh be served thourgh
* a real-time view
* a batch-processing view
    * H-base, Cassandra, HDFS

## Sine Hugh-Level Processing Operation in Big Data Pipelines

transformations also specially named aggregation
> apply function, form one format to another, join data, filter values, ...

### Map
Apply same operation to each member of a collection

### Reduce
Collecting things that have same key

### Cross/ Cartesian
Multiplication
![](https://i.imgur.com/rxbi0A2.png)
Do some process to each pair from two sets

### Match/Join
Selective Multiplcation

![](https://i.imgur.com/yMqgzMr.png)

Do some process to each pair from two sets - which have smae key

### Co-Group
Group common items

![](https://i.imgur.com/wsPvO6a.png)

* Collect similar things first
* Apply a process to each collection

### Filter
Selct elements that match a criteria

> Basic Transformations -> Get Results

## Aggregation Operations in Big Data Pipelines

applying a transformation that takes all the elements of data as input is called "aggrgation"

Sum, Group By, Average, Max, Min, Standard Deviation

### Connecting Aggregations
MAX(SUM)
### Boolean Aggregation
AND, OR
### SETS
dont allow duplicate values
Union, Intersection, Difference
### Strings
Concatenation
### Summary
Aggrgations -> Organized & Compact Data

Variety & Volume -> (Aggregated output) Actionable Insights

---

## Typical Analytical Operations in Big Data Pipelines

### Analytical Operations
Patterns -> Insights -> Decisions

* Purpose
    * Discover meaningful trends and patterns in data
    * Gain insights into problem
    * Make data-driven decisions

### Sample Analytical Operations
* Classification
    * Decision Tree
        * One analytical technique for classification
        * Decisions modeled as a tree
    * Examples
        * Predict wherhter tumor cells are benigh or malignat
        * Categorize handwritten digits
        * Determine whether credit card transaction is legitimate or fraudulent
        * Classify loan application as low, medium, or high-risk.
* Clustering
    * K-Means Clustering
        * Group samples into k clusers
            * In Spark
        ```Python
        # Load and parse the data
        data = sc.textFile("data/mllib/kmeas_data.txt")
        parseData = data.map(lambda line:
            array([float(x) for x in line.split(' ')]))

        # Cluster the data
        clusters = KMeans.train(parsedData, 2,
        maxIterations=10, runs=10,
        initializationMode="random")

        ```
        * Example
            * Group customer base into distinct segments
            * Find articles or webpages with similar topics
            * Identify areas with high incidences of particular crimes
            * Determine weather patterns
* Path analysis
    * Find shortest path from home to work
        * Path analysis using Cypher on neo4j
```Cypher
//Finding shortest path between specific nodes:
match p=shortestPath((a)-[:TO*]-(c))
where a.Name='A' and c.Name='P'
return p, length(p) limit 1

//Find all shortest path:
match p = allShortestPaths((source)-[r:TO*]-(destination))
where source.Name='A' and destination.Name = 'P'
return extract(n in nodes (p)| n.Name) as Paths

```

* Connectivity analysis
    * Analyzing tweets
        * Extract conversation threads
        * Find interacting groups
        * Find influencers in community
    * Connectivity analysis using Cypher on neo4j
```Cypher
//Find the degree of all nodes
match (n:MyNode-[r]-())
return n.Name, count(distinct r) as degree
order by degree

//Find degree histogram of the graph
match (n:MyNode)-[r]-()
with n as nodes, count(distinct r) as degree
return degree, count(nodes) order by degree asc

```

### Machine Learning Algorithms
* Classification
* Regression
* Cluster Analysis
* Associative Analysis

### Graph Analytic Techniques
* Path Analytics
* Connectivity Analytics
* Community Analytics
* Centrality Analytics

### Main Take-Aways
* Analytic operations are used to discover meaningful patterns in data to provide insights
    * e.g.:classification, cluster analysis, path analysis, connectivity analysis
* More analytic are covered in Machine Learning & Graph Analytic courses

## Big Data Processing Tools and Systems

One possible layer diagram for Hadoop tools
Higher levels Interactivity <-> Lower levels: Storage and scheduling

Another way to look at the Hadoop Ecosystem

* Coordination and workflow management
    * ACQUIRE > PREPARE > ANALYZE > REPORT > ACT
    * OOZie
    * Zookeeper
* Data integration and processing
    * ![](https://i.imgur.com/YGApm56.png)

* Data mangament and storage
    * Hadoop HDFS
    * Aerospike
    * Lucene
    * Gephi
    * Vertica
    * Solr
    * mongoDB

---

* Categorization of Big Data Processing Systems
    * Execution Model
        * Batch
        * Streaming
    * Latency
    * Scalability
    * Programming Language
    * Fault Tolerance
* Big Data Processing Systems
    * MapReduce
        * Batch processing using disk storage
        * High-latency
            * no in-memory processing support, the mappers write the data on files before the reducers can read it
            * Hinder the performance of iterative application
        * .
        * Java
            * Provide libraries but less efficiency
        * Replication
    * Spark
        * Batch and stream processing using disk or memory storage
            * RDDs structure
        * Low-latency for small micro-batch size
        * Scala, Python, Java, R
    * Flink
        * Batch and stream processing using disk or memory storage
        * Low-latency
        * Java , Scala
    * Beam
        * Batch and stream processing
        * Low-latency
        * Java and Scale
    * Storm
        * Stream processing
        * Very low-latency
        * Many programming languages
    
### Lambda Architecture
A Hybrid Data Processing Architecture
![](https://i.imgur.com/SWJ3cGy.png)
more general framework that can combine the results of stream and batch processing executed in multiple big data systems
![](https://i.imgur.com/KC1RLuD.png)
Using Spark for both batch and speed layers.

---

## Introduction to Apache Spark

* Hadoop MapReduce Shortcomings
    * Only for Map and Reduce based computations
        * not always the most efficient way
            * e.g.: filter, join, data pipeline with server steps including joins and group by
        * Relies on reading data from HDFS
            * A problem for iterative algorithms 
                * performance bottleneck due to IO
                    * not ideal for ML
        * Native support for Java only
            * not very efficient especially when running not with text data but with floating numbers.
        * No interactive shell support
        * No support for streaming

> Spark came out of the need to extend the MapReduce framework to overcome this shortcomings

### Basics of Data Analysis with Spark
* Expressive programing mdoel
* In-memory processing
* Support for diverse workloads
* Interactive shell

### Spark Stack
![](https://i.imgur.com/N2RfRmt.png)

* Spark Core
    * Distributes and monitors tasks across the nodes of a commodity cluster
    * The core capability is of the Spark Framework are implemented.
    * Importan part of Spark Core is the APIs for defining resilient dirtributed data sets(RDDs)
        * Main programming abstraction in Spark
        * Carry data across many computing nodes in parallel and transform it.
* SparksSQL
    * provide querying structured and unstructured data
    * Connect to many data sources and provide APIs to convert query results to RDDs in Python, Scala and Java programs.
* Spark Streaming
    * where data manipulations take place in Spark
    * Alouth, not a native real-time interface to datastreams, Spark streaming enalbes creating small aggregates of data coming from streaming data ingestion systems
* MLlib
    * native library for ML algorithms and evaluatation
* GraphX
    * Graph analytics library of Spark
    * Enables the Vertex edge data model of graphs to be converted into RDDs as well as providing scalable implementations of graph processing algorithms.

> Explore > Build > Scale


## Getting Started with Spark

MapReduce:write re Disk - very slow

![](https://i.imgur.com/Kr70Czo.png)

* Resilient Distributed Datasets
    * Dataset
        * immutable
        * Data sotrage created from:
            * GDFS, S3, HBase, JSON, text, Local hierarchy of folders
        * Or created transforming another RDD
    * Distributed
        * Distributed across the cluster of machines
        * Divided in partitions, atomic chunks of data
    * Resilient
        * Recover from errors
            * e.g.:node faulure, slow processes
        * Track history of each partition, re-run

### Spark Architecture

![](https://i.imgur.com/iv9xrNI.png)


* Driver Program
    * distributes RDDs on ur computational cluster and make sure the transformations and actions on these RDDs are performed 
    * create a connection to a Spark cluster or local Spark through a Spark context object
        * `lines = sc.textFile("hdfs:/user/cloudera/words.txt")`
* Worker Node
![](https://i.imgur.com/7YcMBYp.png)
 * where Spark operations execute
 * keep running java virtual machine JVM
 * many worker nodes
     * ![](https://i.imgur.com/9QKZdOq.png)

### [Which cluster manager?](http://www.agildata.com/apache-spark-cluster-managers-yarn-mesos-or-standalone/)


### Summary
![](https://i.imgur.com/mqpuL9X.png)
### Cloudera VM
![](https://i.imgur.com/jDCVJZS.png)

---
## Hands-on

Sudo pyspark

lines = sc.textFile("hdfs://localhost/user/cloudera/words.txt")
lines.take(5)
wors = lines.flatMap(lambda line: line.split(""))
lines.take(5)
tuples = words.map(lambda words: (words, 1))
counts = tuple.reduceByKey(lambda a, b: (a+b))
counts.coalesce(1).saveAsTextFile("hdfs://localhost/user/cloudera/wordcount/outputDir")


### Quiz
words = lines.flatMap(lambda line: line.split(“ “))
>  Each line in the document is split up into words.


words = lines.flatMap(lambda line: line.split(“ “))
> Each Spark partition corresponds to a line in the document.

When the following command is executed, where is the file written and how can it be accessed?
counts.coalesce(1).saveAsTextFile(‘hdfs:/user/cloudera/wordcount/outputDir’)
> HDFS and through the “hadoop fs” command.

What does the number one (1) allow us to do in the following line of code?words.map(lambda word: (word,1))
> Treat each word with a weight of one during the counting process.


---

# Week5
## Programming in Spark
### Spark Core: Porgramming In Spark using RDDs in Pipelines

![](https://i.imgur.com/zgFbKA6.png)

### Creating RDDs

* Driver Program
    * lines = sc.textFile("hdfs:/user/cloudera/words.txt")
    * lines = sc.paralleize(["big","data"])
    * numbers = sc.parallelize(range(10), 3)
        * Paralleize range output into 3 partitions
            * [0,1,2],[3,4,5],[6,7,8,9]
    * numbers.collect()

### Processing RDDs

![](https://i.imgur.com/73dipKe.png)
Lazy evalutation for transformations: not be immediately executed, transformations get computed when an action is executed.

![](https://i.imgur.com/m2woSLY.png)

We need to use caution when using the cache option, as it can consume too much memory and generate a bottleneck itself.

![](https://i.imgur.com/HcmQvAq.png)

### Programming in Spark

Create RDDs -> Apply transformations -> Perform actions


## Spark Core: Transformations

### Narrow Transformation
> Happen in a worker node locally without having to transfer data through the network.


map:apply function to each element of RDD
flatMap:map then flatten output
filter:leep only elements where function is true
coalesce:reduce the number of partitions

### WIde Transformations
> processing depends on data residing in multiple partitions distributed across worker nodes and this requires data shuffiling over the network to bring related datasets together.

groupByKey: (K, V)pairs => (K, list of all V)
groupByKey+reduce
reduceByKey


## Spark Core Actions
* Action
    * collect()
        * Copy all elements to the driver
    * take(n)
        * Copy first n elements
    * reduce(func)
        * Aggregate elements with func(take 2 elemtents, reuturns 1)
    * saveAsTextFile(filename)
        * Save to local file or HDFS

---

## Main Modules in the Spark Ecosystem

### SparkSQL
* Enable querying structured and unstructured data through Spark
* Provides a common query language
* Has APIs for Scala, Java and Python to convert results into RDDs


### Relational Operations
* Perform Relational Processing such as Declarative Queries
* Embed SQL queries inside Spark Programs

### Business Intelligence Tools
Spark SQL connects to all BI tools that support JDBC or ODBC standard.

### DataFrames
* Distributed Data organized as named columns
* Look just like a table in relational databeses


### How to go Relational in Spark?
* Step1:Create a SQLContext
* Create a DataFramee from
    * an existing RDD
    * a Hive table
    * data sources

### JSON -> DataFrame
```Python
# Read
df = sqlContext.read.json("/filename.json")

#Display
df.show()
```

### RDD of Row objects -> DataFrame
### DataFrames are just like tables
### Spark SQL
Relational on Spark
Connect to variety of databases
Deploy business intelligence tools over Spark

## Spark Streaming
* Scalable processing for real-time analytics
* Data streams converted to discrete RDDs
* Has AOIs for Scala, Java, and Python
### Sources
* Kafka
* Flume
* HDFS
* S3
* Twitter
* Socket
* ...etc
### Creating and Processing DStreams
### Main Take-Aways
* Spark uses DStreams to make discrete RDDs from streaming data.
    * Same transformations and calcuations applied to batch RDDs can be applied
* DStreams can create a sliding window to perform calculations on a window of time.


## Spark MLlib
* Scalable machine learning library
* Provides distributed implementations of common machine leraning algorithms and utilities
* Has APIs for Scala, Java, Python, and R

### MlLib Algorithms & Techniques
* Machine Learning
    * Classification, regression, clustering, etc.
    * Evaluation metrics
* Statistics
    * Summary statistic, sampling, etc.
* Utilities
    * Dimensionality reduction, transformation, etc.

### MlLib Example - Summary Statistics
* Compute column summary statistics
### Main Take-Aways
* MLlib is Spark's ML libray
    * Distributed implementations
* Main categories of algorithms and techniques:
    * Machine learning
    * Statistics
    * Utility for ML pipeline
## Spark GraphX
GraphX is Apache Spark's API for graphs and graph-parallel computation.
* GraphX uses a property graph model
> Both Nodes and Edges can have attributes and values

* Properties -> Tables

GraphX uses special RDDs

### Triplets
The triplet view logically joins the vertex and edge properties.

### Pregel API
* Bulk-synchronous paralle messagin mechanism
* Constrained to the topology of the graph

### GraphX
* Graph Parallel Computations
* Special RDDs for storing Vertex and Edge information
* Pregel operator works in a series of super steps

---

### Quiz:
Where does the data for each worker node get sent to after a collect function is called?
> Spark Context

What are DataFrames?
> A column like data format that can be read by Spark SQL.

Can RDD's be converted into DataFrames directly without manipulation?
> No: lines have to be converted into row.

What is a triplet in GraphX?
> A type of data to contain the information on connections between vertices and edges.

---

## Hands-on
Data processing in Spark

```Jupyter
sqlsc = SQLContext(sc)

df = sqlsc.read,format("jbdc") \
    .option("url," "jdbc:postgresql://localhost/cloudera?user=cloudera") \
    .option("dbtable, "gameclicks") \
    .load()
    
df.printScheam()
df.count()
df.show(5)
df.select("userid", "teamlevel").show(5)
df.filter(df["teamlevel"] > 1).select("userid," "teamlevel").show(5)
df.groupBy("ishit").count().show()
from pyspark.sql.functions import *
df.select(mean("ishit"), sum("ishit")).show()

df2 = sqlsc.read,format("jbdc") \
    .option("url," "jdbc:postgresql://localhost/cloudera?user=cloudera") \
    .option("dbtable, "adlicks") \
    .load()
df2.printScema()    
merge = df.join(df2, "userid")
merge.printSchmea()
```

Analyzing Snesor Data with Spark Streaming

```Python
import re
def parse(line):
    match = re.search("Dm=(\d+)", line)
    if match:
        val = match.group(1)
        return [int(val)]
    return []
    
from pyspark.streaming import StreamingContext
ssc = StreamingContext[sc, 1]

lines = ssc.socketTextStream('rtf.hpwren.ucsd.edu', 12028)
vals = lines.flatMap(parse)
window = vals.wind(10,5)
def stats(rdd):
    print(rdd.collect())
    if rdd.count() > 0:
        print("max = {} min = {}".format(rdd.max(), rdd.min()))
window.foreachRDD(stats)
ssc.start()
ssc.stop()
```

ssc = StreamingContext(sc,1)
> A batch interval of 1 second. 

window = vals.window(10, 5)
> Creates a window that combines 10 seconds worth of data and moves by 5 seconds.

---

# Week6

## Assignment: Querying and Exporting from MongoDB

db.users.find({"user.Location":{$ne:null}}).count()
> 若非nest第一層 需加""

db.users.find({$where : “this.tweet_mentioned_count > this.tweet_followers_count”}).count()
> 改寫

db.users.find({$text:{$search:"http://"}})

db.users.createIndex({"tweet_text": "text"})
db.users.find({$text : {$search:"http -Texas"}}).count()

db.users.find({$and : [{$text: {$search : "http -UEFA"}}, {"tweet_text" :/Ruro 2016}]}).count()
> wrong

db.users.find({$and : [{"user.Location" : "Ireland"},{"tweet_text" : /UEFA/}]},{"user.FriendsCount":1, _id:0}, user_name:1)


Although it is possible to just work with MongoDB on some analytical platforms, a lot of data scientists use an analysis platform that cannot work with MongoDB directly. A common practice in data science is to export all or part of the data into a CSV file that almost any analytical tool can import. 

---

### Analysis using Spark

[setup script](https://github.com/words-sdsc/courseraDataSimulation/blob/master/capstone/readings/setupWeek3.sh)

```Python
# Read the country CSV file into an RDD.
country_lines = sc.textFile('file:///home/cloudera/Downloads/big-data-3/final-project/country-list.csv')

# Convert each line into a pair of words
pair_of_words = country_lines.flatMap(lambda line: line.split("\n"))

# Convert each pair of words into a tuple
country_tuples = pair_of_words.map(lambda word: (word.split(',') [0], word.split(', ')[1]))

# Create the DataFrame, look at schema and contents
countryDF = sqlContext.createDataFrame(country_tuples, ["country", "code"])
countryDF.printSchema()

# Read tweets CSV file into RDD of lines
tweet_texts = sc.textFile('file:///home/cloudera/Downloads/tweets.csv')

# Clean the data: some tweets are empty. Remove the empty tweets using filter() 
non_empty_tweet_texts = tweet_texts.filter(lambda x : len(x) > 0)

# Create the DataFrame of tweet word counts
tweetDF = sqlContext.createDataFrame(word_counts, ["word", "count"])

# Join the country and tweet data frames (on the appropriate column)
from pyspark.sql.functions import col 
joinedDF = countryDF.alias('c').join(tweetDF.alias('t'),col('c.country') == col('t.word')).select(col('c.code'), col('c.country'), col('t.count'))

# Question 1: number of distinct countries mentioned
joinedDF.count(), joinedDF.select('code').distinct().count()

# Question 2: number of countries mentioned in tweets.
from pyspark.sql.functions import sum
from pyspark.sql.functions import desc
joinedDF.agg(sum("count")).first()
descSorted = joinedDF.sort(desc("count"))
descSorted.show(5)

selectedDF = joinedDF.where((col("country") == "Kenya") | (col("country") == "Wales") |(col("country") == "Netherlands")).sort(desc("count"))
from pyspark.sql.functions import avg 
joinedDF.agg(avg("count")).first()

```










###### tags: `Big Data`




