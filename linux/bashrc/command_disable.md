# Command disable

In my new company's git flow,
we can only push to fork repository,
and make pull request to the original repository,
here's a problem that I could accidentally push to the original repository,
so I need to disable the push command to the original repository.

> But what should you do with some personal repository that you can push directly? 
> Just use another remote name, such as `personal`,
> and don't add this remote name to repository that you don't want to push directly.

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
