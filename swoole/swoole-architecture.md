# Swoole Architecture

## Thread and process

Thread is included in Process,
Thread is a process execution unit.

### Multi-Task

* Multi-Process
* One Process and Multi-Thread
* Multi-Process and Multi-Thread

### Multi-Process vs Multi-Thread

|                      | Multi-Process                                                                                             | Multi-Thread                                    |
|----------------------|-----------------------------------------------------------------------------------------------------------|-------------------------------------------------|
| Stability            | High(Resources are spearated, if one failed, won't influence others)                                      | Low(One thread failed, the whole process crash) |
| Performance and number | More process/thread doesn't mean the performance will be better, since the resource switch manage         | same                                            |
| Implement | More complex, need additional method to communicate with other process(e.g. shared memory, message queue) | More simple |


### Swoole Architecture

| Character   | Type                   |
|-------------|------------------------|
| Master      | Process                |
| Manager     | Process                |
| Worker      | Process(Multi-Process) |
| Task Worker | Process(Multi-Process) |
| Reactor     | Thread(Multi-thread)   |

### Master

Main process

* create main reactor
* create and manage reactor
* create Manager to handle client request

### Reactor

Listen to socket, receive request, 
and dispatch request to Worker or Task Worker.

Multi-thread, asynchronous, non-blocking

### Manager

Catch Worker end signal,
and create new Worker to replace it,
Maintain number of Worker.

### Worker

Multi-Process.

Actual worker to handle request.

### Task Worker

Multi-Process.

Get task from Worker,
and handle it,
then return result to Worker.

### Communicate inside process

Use Unix Socket, managed by Reactor.
