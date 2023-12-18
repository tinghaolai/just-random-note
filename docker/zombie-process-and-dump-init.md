# Zombie process and dump init

## Zombie

What would cause zombie process?

Child process is not waited by parent process.

## Why would happen in docker?

Docker environment lacks of init process such as `systemd`.

These application is to handle signal and handle child process,

Without these, 

child process would become zombie.


## Example

When using crontab in docker,

every time crontab execute a command,

it would create a child process,

and the child process would become zombie.


## Solution

Use `dumb-init` to handle signal and child process.

### Example

```yaml
RUN apt install dumb-init
ENTRYPOINT ["/usr/bin/dumb-init", "--"]
```
