## Inverted Index

Fast full-text searching.

Term dictionary: use keyword (term) to get document position.

Why it's inverted? Instead of finding keyword from content, it finds content from keyword.

### Term Index

There's one more optimize before term dictionary, 
that's term index,
it can find term dictionary faster.

### Support fast complex search

* Boolean search
* Range search
* Fuzzy search
* Wildcard search
* Proximity search

### Distributed search

We can use multiple nodes to search data,
merge result from multiple nodes,
make search faster.