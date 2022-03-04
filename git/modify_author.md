## Modify author

### Use case

Commit author can't not link to github account, although the user and email of commit author info is correct, but still not work. There'sa big chance that I break my git config after switch author account setting. 

### Solution

`git rebase -i sha`

`git commit --amend --author="Author <email@gamil.com>" --no-edit`
> In each rebasing

`git rebase --committer-date-is-author-date SHA`
