## Ignore

If you are working on a big project, and you have lots of file or change don't want to commit, such as testing code or something makes development easier, then when you want to make a commit, You have to pick the files you want to commit instead of the changes for develop.

This could take lots of time to do that especially you don't have some powerful IDE such as JetBrain's commit UI, There's my own way to do that: Ignore manually.

### Ignore manually

1. Find the files you don't want to commit.
2. Save the reset command to someplace to copy it when needed
    * `git reset App\TestA.php App\TestB.php public\index.js`
3. When u need to commit all current change, run `git add .`
4. Run the reset command copied
