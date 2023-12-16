## No duplicate random number

Let's say you want to generate 10 random numbers between 1 and 100,
and you don't want any duplicates.

How do you do it?

### While loop

Generate a random number,
If the number is not in the has,
add it to the hash,
loop until the hash has 10 numbers.

Cons: High possibility to generate the same number when the hash is almost full.

### Shuffle

Generate an array of 100 numbers,
shuffle the array,
get the first 10 numbers.

### Data structure

todo:
To research and implement a data structure that can do this.

Concept:
Like hash,
when access this hash,
get corresponding value,
after fetch the value,
delete the vale from the hash.
and next time fetch the same way in this hash,
if won't get the same value but next value,
so you don't need to check and loop again,
there still might be a chance need to loop again when out of index,
but the possibility is much lower than while loop.

