Graph Analytics for Big Data
===

# Week1
just intro
# Week2
## What is a Graph?
chart!=graph
> Charts represent the graph of a function

### Mathematical Definition
* V: a set of vertices
* E: a set of edges
### Computer Science definition
* An abstract data type
    * Has a data structure to represent the mathematical graph
        * Matrix
        * ![](https://i.imgur.com/aYC7Jkl.png)
            * operations become more efficient

    * Supports a nubmer of operations(on the graph)
        * Add_edge
        * Add_vertex
## Why Graphs?
![](https://i.imgur.com/AnSNb1S.png)
### 4 Use Cases
* Social Media Analytics
* Gene-Phenotype-Disease Networks
* Human Information Network Analytics
* Analysis and Planning for Smart Cities
    
### Social Networking
* Social Media Analytics
    * Behavioral Psychology
        * A branch of psychology that studies people's behavior
    * Data Science questions of a behavioral psychologist
        * Do players of violent online games show more confrontional behavior in their tweet conversations?
        * Can we tell how "addicted" a user is to game?
* Why Graph
    * Extracting Conversation Threads
    * Finding Interacting Groupts
    * Finding Influencers in a Community
### Biological Networks
* Biological Entities Interact
    * Networks arising from
        * Experimental observations
            * Gene-portein relationships
            * Gene-gene interactions
            * Cell-cell signaling
            * Gene-phenotype-disease relationships
        * Human Knowlege
            * Anatomical knowledge
            * Taxonomy of the animal kingdom
* Computed Relations
    * Networks arising from
        * Computational Techniques
            * Bioinformatics algorithms
            * Literature mining
* Data Integration
    * Data sets must be assembled
    * More data integration = larger data volume
* Why Graphs?
    * Discovering Unknow Relationsships
        * Connecting the dots
            * Indirect associations between diseases
            * Exploratory analysis

### Human Information Network Analytics
* Combining
    * Professional information
        * e.g.,LinkedIn
    * Personal information made public
        * e.g.,FB, Google Plus
    * Calendar information
    * Contact/Relationship information
    * Public co-activities with other people
    * Organized by time and events
    * Annotated with events
* Behavioral information
    * Financial and business transcations
    * Performance in activites
    * Fiteness habits
    * Location information
* Why Graphs
    * Maych making problems
        * Job-candidate pairing
    * Topical influencer analysis
        * Who would have maximal reach for task X?
    * Situation detection, assessment
        * Threat detection
### Smart Cities
Cities have networks
* Multiple interacting networks over the smae spatial domain
    * Transportation networks
        * multiple modalities
    * Water and sewage network
    * Power transmission network
    * Broadband IP and M2M networks
* Networks should be modeled
    * Multiple functionalities of each network
        * Physical infrastructure
        * Commodity flow
            * Material
            * Energy
            * People
    * Need to create "network models"
        * Analytical traffic model
            * Congestion models
* Why Graphs
    * Planning for "smart hubs"
    * Estimating congestion patterns
    * Demand response analyses
    * Energy-optimal routing

### The Purpose of Analytics
What is Analytics
* Discovery and communication of meaningful patterns or interesting insight using
    * Mathematical proerties of data
    * Data computing for accessing and manipulating data
    * Domain knowlegde to increase interpretability of data and results of analytics
    * Statistical modeling techniques for drawing inferences or making predictions on data

Some Broad Purposes of "Analytics"
* Uncover characteristics of data set based on its mathematical properties
* Anaswer specific questions from multiple data sets
* Develp a mathematical model for predicting the behavior of some variables
* Detect emergent phenomena and explain its contributing factors

Graph Analytics
* Analytics where the underlying data is natively structured as or can be modeled as a set of graphs

---

## Graph in the real world

* well know V's
    * Volume
        * The size of the graph grows much larger than memory
            * Is there a simple path?
                * Well-know hard decision ploblem
            * How many simple pathes exist
                * Hard computing problem
                * Size of result is exponential in the nubmer of nodes
    * Veclocity
        * The graph gets incrementally bigger as new graph content gets added from (many) fast streams
        * Social Media
            * Stream of updates = stream of edges
        * Compute a Metric
            * shortest distance between two nodes
            * Count of strongly coonected groups
        * A continuous stream does not fit in memory
            * How can these metrics be computed on the edge-stream with limited memory?
    * Variety
        * The graph gets more non-uniform and complex
        * Graph data is often created through integration
        * Different kinds of graphs with very different meaning
        * Graph data is often created throught integration
            * Relationla, XML/JSON, Grpah-strucutred, Document
        * Different knids of graphs with very different meaning
            * Soical networks, citation networks, interaticon networks, semantic web/linked data, ontologies
* lesser known V
    * Valence
        * Increasing connectedness
        * in many cases, increases with time
            * parts of the graph become denser
            * Average distance between arbitrary node pairs decreases
        * graph analytics methods for
            * modeling the "valence effect"
            * managing the "valence effect"
### Graph size impacts analytics
* Increases Algorithmic complexity
* Data-to-analysis time is too high

---

## Quiz
Which of the Vs BEST describes the result in constant increasing in the number of edges in a graph, sometimes causing challenges in knowing when one has found "an answer" to one's analysis question?
> Velocity, Volume isn't JUST about increasing edges.(if chose volume)


Which of the Vs results in increased algorithmic complexity (which can cause analyses to not be able to finish running in reasonable amounts of time)?
> Vp;ime, Variety is about kinds of data and the challenges of integration.(if chose variety)


---
## Homework- self design

1. What kind of game that the viewer might be interested?
Analyze what other games that viewers also watch with one specific game, check viewer nodes whick watch the specific streaming game, and other game they watch.
Why: Recommend to viewers what games they might interested.

2. How related bewteen viewer's subscription and game they most watching?
Analyze subscription through viewer node, streamer node, game node, and compare with the games viewer most watch through viewer node, game node.
Why: Impact the strategy that how much the company should focus on the non-mainstream games.

3. What's the trend about popular game?
See the change about the game that viewers mostly watch, and compare with the most popular games.
Why: Analyze which game will bring more viewers to the streamer and platform.

# Week 3
## Big Data and Graph Analytics
Node types(Labels)
Node Schema = Properties(Attributes) with Values
Edge schema
![](https://i.imgur.com/cCTyYv7.png)
* Weight - an Edge Property
* Structural Property of a Graph
* Multi-graph
    * A graph with more than one edge between two nodes
        * different infromation content

---

* Walk
    * an alternating sequence of vertices and edges over a graph
* Constraing a Walk
    * Path
        * A walk with no repeating node except possibly for the first and last
    * Cycle
        * A path of length n>=3 whose start and end vertices are the same
    * Acyclic
        * Graph with no cycles
    * Trail
        * A walk with no repeating edge
* Reachability
    * node u is reachable from node v if there is a path from u to v

### Diameter of a Graph
The diameter is the longest "shortest path" between any set of nodes.
Maximum pairwise distance between nodes
shortest path
![](https://i.imgur.com/4qxTO9F.png)

### The Basic Path Analytics Question
* What is the best path to go from node 1 to node 2?
    * Specification of "best" may include
        * Function to optimize
        * Nodes/edges to traverse
        * Nodes/edges to avoid
        * Preferences to satisfy
* Find
    * least weight path (optimization function)
        * A Standard Meothd: Dijkstra's algorithm
            * ![](https://i.imgur.com/8SHlzr2.png)
            * Constructu Path: from target to source
            * The worst-case complexity of Dijkstra is propertional to the number of edges times log(number of nodes)
                * really high
            * Constraints case
                * Avoid paths through E & Must go through J
                    * Splitting the task
                    * Operating over a relevant subgraph

> Routes on Google Maps: Shortest route would change based on weather, traffic, road condition...
---

## Quiz

A loop in a graph is where
> where there is an edge from a node to itself.

---

## Connectivity Analytics
Q: how robust is thegraph?
> how eays it it to break the graph by removing a few nodes/edges?

Q:How similar is the strucutre of graph
> * What are some computatlbe features that can describe the structure of a graph
> * How can 2 hraphs be compared based on these features?

* Coneectedness
* Strongly connected: visited by a single path
* Weakly connected: connected after converting a directed graph to undirected
* Computing Prolbems
    * Scalable solution for finding
        * Connected components of a graph
        * Strongly connected fragments of a graph

### Disconnecting a Graph
* Node Based
    * Spearating Set:remove set:S, such that has more than one component
    * Connectivity of graph: minimum size of S
* Edge Based
    * Disconnecting set (of edges)
    * Edge-connectivity of graph

==Network Robustness==
* If node v is reachable from node v originally, it should remain reachable even if the network is attacked.
* Attcked
    * Node/edge removed


> Higher degree nodes make the network more vulnerable
> So, attack pripor = most connected


### Indegree and Outdegree

* Degrees
    * Indegree of a node: incident edges
    * Outdegree of a node: emanating from it
    * Degree: total
* Graph similarity
    * Vector distance functions
        * Euclidian distance
    * Many other distance functions

==Joint Degree Histograms==
One can also comput the in-degree and out-degree histograms of a graph

![](https://i.imgur.com/7P4qbNY.png)

### Community Analytics and Local Properties

* Community
    * Entites oftern interact within groups
    * Interactions from clusters
    * Community
        * a dense subgraph(cluster)within a graph whose nodes are more connected within the cluster thant to nodes ouside the cluster


* Detecting a Community
    * ![](https://i.imgur.com/nLa3oQK.png)

    * c - connected subgraph of graph G
    * compute
        * The internal and exteranl degree of a vertex
            * interanl - within C
            * external - outside C
        * The internal and external degree of the cluster C
            * Sum of the interal/external degree of the vertices of C
            * Intra-cluster density(int)
            * Inter-cluster density(ext)
        * Fro c to be a community
            * Intra should be high and Inter should be low

==Local Properties==
Properties of a subgraph and its neighborhood
* Clique
    * ![](https://i.imgur.com/WDTVewa.png)

    * The perfect community
        * every two distinct vertices in the clique are adjacent
    * Finding the largest clique within a graph
        * Computationally hard problem
        * Simpler to find cliques of size k
* Near Cliques
    * n-clique
        * Maximal subgraph such that the distance of each pair of its vertices is not larger than n
            * n = 1 for a clique
* Finding dense parts of a grpah
            * 2 clique
            * ![](https://i.imgur.com/CTKClIy.png)

   * n-clan
       * An n-cluque in which geodesic distance between nodes in the subgraph is no greater than n
       * 2-clan, each nodes connected no greater than 2
           * ![](https://i.imgur.com/FZGF7bI.png)

   * k-core
        * Maximal subgraph in which each vertex is adjacent to at least k other vertices of the subgraph
        * ![](https://i.imgur.com/gpBkXpK.png)

### Golbal Property: Modularity
Modularity
* A global measure of cluster quality
    * fraction of the edges within the given groups within minus the expected such fraction if edges were distributed at random.
    * value of the modularity lies in the range[-1/2,1]
![](https://i.imgur.com/a4ciNKw.png)

[Louvain methd](https://www.youtube.com/watch?v=dGa-TXpoPz8)

### Centrality Analytics

The nodes more important than others
* Influencers in a social network
* A junction station in a transport network
* A hous-keeping gene in a biological network
* A central server in a computer network

==Key Player Problems==
* ==Centrality==
    * Measure of importance of a node(edge) based on its position in the network
    * Diifefent ways to measure
* ==Centralization==
    * Measure for a network and not a node
    * Degree of variation in the centralitu scores among the nodes
    * $\dfrac{\Sigma{(c_{max}-c(v_i))}}{c_{max}}$
* Degree Centrality
    * Count of the number of edges incident upon agiven node normalized by the possible number of edges
        * (# of edges)/(N-1)
    * hub(maximally-connected)nodes
* Group Degree Centrality
    * Consider a group as a single entity
    * Count of the number of edges incident upon the group normalized bu mpm-group members
        * \# of edges into the group / #of non-group members
* Closeness Centrality
    * Sum of shortest-path distances from all other nodes(nomalized)
        * Low raw closeness means node has short distance from other nodes.
    * For an information flow network
        * Low closness nodes receive information sooner than other nodes
            * Same for other flows if the flow happens though shortest paths
            * gossip?
        * A low closeness can influence many others, directly and indirectly.
* Betweenness Centrality
    * Ratio of pairwise shortest paths that flows through node i and count of all shortest paths in the graph
    * Measures fraction of shortest-path commodity flow passing thorugh a node
        * Not applicable to non-flow situation
        * Not applicable when shortest path routes are not taken.


### Optional
---

# Week 4
## Graph Analytics with Neo4j
setup
> In new version
    After opening the Neo4j desktop application, you need to click 'My Project' on the left sidebar.
    Then click on 'New Graph' on the lower right side of window.
    Then click 'Create a Local Graph'.
    Thats when you get the prompt to create a new graph database. Give some name to the Graph database, say Graph1, set your own password and hit create button.
    Then click on 'Start' button. This will set the database server in active mode for the current project (not sure if i stated that correctly but this will do the trick).
    All set!! now you can either open the Neo4j browser from the top right section of screen or go via 'manage' button as Jeff indicated above.


```Neo4j
//Adding a Node Correctly

match (n:ToyNode {name:'Julian'})

merge (n)-[:ToyRelation {relationship: 'fiancee'}]->(m:ToyNode {name:'Joyce', job:'store clerk'})

//Adding a Node Incorrectly

create (n:ToyNode {name:'Julian'})-[:ToyRelation {relationship: 'fiancee'}]->(m:ToyNode {name:'Joyce', job:'store clerk'})

//Correct your mistake by deleting the bad nodes and edge

match (n:ToyNode {name:'Joyce'})-[r]-(m) delete n, r, m

//Modify a Node’s Information

match (n:ToyNode) where n.name = 'Harry' set n.job = 'drummer'

match (n:ToyNode) where n.name = 'Harry' set n.job = n.job + ['lead guitarist']
```

### Modifying a Graph

```Neo4j
//One way to "clean the slate" in Neo4j before importing (run both lines):

match (a)-[r]->() delete a,r

match (a) delete a

//Script to Import Data Set: test.csv (simple road network)

//For Windows use something like the following

//[NOTE: replace any spaces in your path with %20, "percent twenty" ]

LOAD CSV WITH HEADERS FROM "file:///C:/coursera/data/test.csv" AS line

MERGE (n:MyNode {Name:line.Source})

MERGE (m:MyNode {Name:line.Target})

MERGE (n) -[:TO {dist:line.distance}]-> (m)

//For mac OSX use something like the following

//[NOTE: replace any spaces in your path with %20, "percent twenty" ]

LOAD CSV WITH HEADERS FROM "file:///coursera/data/test.csv" AS line

MERGE (n:MyNode {Name:line.Source})

MERGE (m:MyNode {Name:line.Target})

MERGE (n) -[:TO {dist:line.distance}]-> (m)

//Script to import global terrorist data

LOAD CSV WITH HEADERS FROM "file:///Users/jsale/sdsc/coursera/data/terrorist_data_subset.csv" AS row

MERGE (c:Country {Name:row.Country})

MERGE (a:Actor {Name: row.ActorName, Aliases: row.Aliases, Type: row.ActorType})

MERGE (o:Organization {Name: row.AffiliationTo})

MERGE (a)-[:AFFILIATED_TO {Start: row.AffiliationStartDate, End: row.AffiliationEndDate}]->(o)

MERGE(c)<-[:IS_FROM]-(a);
```
### Importing Data
## Basic Querying, Path Analysis and Centrality Analysis

---
# Week 5
## Programmind Model for Graphs
Module Plan
* Programming Model for Scalable Graph Computation
    * Bulk Synchronous Parallel(BSP)
    * Pregel and Graphlab
* Graph Computing Platforms
    * Apache Giraph
    * Spark GraphX





###### tags: `Big Data`





















