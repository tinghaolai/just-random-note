## Using two git account in one computer

When you need to use different git account to commit by project, it will be such a painful to switch git account frequently.

### My solution


Run a docker instance to link all git project folder, each git account has one docker instance, then you can commit with the account you want by using relative docker image.