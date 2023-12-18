| Operation                                     | Time                  |
|-----------------------------------------------|-----------------------|
| Open a website                                | a few seconds         |
| Database query (with index)                   | tens of milliseconds |
| Execute a command on a 1.6G CPU               | 0.6 nanoseconds      |
| Sequentially read 1M data from a mechanical disk | 2-10 milliseconds  |
| Sequentially read 1M data from SSD             | 0.3 milliseconds     |
| Sequentially read 1M data from memory          | 250 microseconds     |
| CPU read from contiguous memory               | 100 nanoseconds      |
| 1G network card, transfer 2kb data over the network | 20 microseconds |