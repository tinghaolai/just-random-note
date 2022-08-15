## Account permission

First of all, always not to trust ssh tool copy feature, it may even not paste anything, that's why I stuck a lot more time at this problem.

## Modify mysql flag

Don't event try to ssh instance to modify privileges, cuz it's not allowed, which is totally wasting your time.
What you should do is execute gcloud command like `gcloud sql instances patch dave-test  --database-flags sql_mode=TRADITIONAL`,
or just use GUI to modify DB settings. (Which in instance/edit)
