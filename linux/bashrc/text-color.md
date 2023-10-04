## Text color

```bash
function set_random_color_prompt() {
    local colors=("31" "32" "33" "34" "35" "36" "91" "92" "93" "94" "95" "96")
    local random_color=${colors[$((RANDOM % ${#colors[@]}))]}
    PS1="\[\e[01;${random_color}m\]\u@\h:\w\$ \[\e[0m\]"
}

PROMPT_COMMAND=set_random_color_prompt
```