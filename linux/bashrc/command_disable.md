# Command disable

In my new company's git flow,
we can only push to fork repository,
and make pull request to the original repository,
here's a problem that I could accidentally push to the original repository,
so I need to disable the push command to the original repository.

```bash
function git() {
    if [[ $1 == "push" && $2 == "origin" ]]; then
        echo "Error: git push origin is disabled."
        return 1
    else
        # Call the actual git command with the arguments
        command git "$@"
    fi
}
```
