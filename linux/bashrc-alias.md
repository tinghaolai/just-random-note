<!--HugoNoteFlag-->

---

## Bashrc

1. `vim ~/.bashrc`
2. enter alias
3. `source ~/.bashrc`

```bash
alias vimrc="vim ~/.bashrc"
alias vimfrpc="vim /app/frpc/frpc.ini"
alias frpcreload="systemctl restart frpc"
alias sourcerc="source ~/.bashrc"
alias cdsso="cd /app/sso"
alias cdssof="cd /app/sso-spa"
alias cdv2="cd /app/cdp_2-0"
alias cdv3="cd /app/cdp_v3"
alias cdspa="cd /app/cdp_ts_vue3_spa"
alias dc="docker-compose"
alias cdle="cd /app/just-random-note/playground/laravel_10_explore"
alias lebuild="docker exec laravel_10_explore_app_front_1 npm run build"
alias leenter="docker exec -it laravel_10_explore_app_1 /bin/sh"
alias sail='./vendor/bin/sail'
alias taillog='current_date=$(date +'%Y-%m-%d') && new_log_file="storage/logs/laravel-$current_date.log" && tail -f "$new_log_file"'
```

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## Bashrc

1. `vim ~/.bashrc`
2. 輸入別名
3. `source ~/.bashrc`

```bash
alias vimrc="vim ~/.bashrc"
alias vimfrpc="vim /app/frpc/frpc.ini"
alias frpcreload="systemctl restart frpc"
alias sourcerc="source ~/.bashrc"
alias cdsso="cd /app/sso"
alias cdssof="cd /app/sso-spa"
alias cdv2="cd /app/cdp_2-0"
alias cdv3="cd /app/cdp_v3"
alias cdspa="cd /app/cdp_ts_vue3_spa"
alias dc="docker-compose"
alias cdle="cd /app/just-random-note/playground/laravel_10_explore"
alias lebuild="docker exec laravel_10_explore_app_front_1 npm run build"
alias leenter="docker exec -it laravel_10_explore_app_1 /bin/sh"
alias sail='./vendor/bin/sail'
alias taillog='current_date=$(date +'%Y-%m-%d') && new_log_file="storage/logs/laravel-$current_date.log" && tail -f "$new_log_file"'
```