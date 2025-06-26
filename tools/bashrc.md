```bash
#trade
alias tradeactive="source ./ta-lib/.venv/bin/activate"
alias tradefetch="python fetch-data.py"
alias tradetest="python back-test-v2.py"
alias tradetest3="python back-test-v3-no-ai.py"
alias tradeactive="source ./ta-lib/.venv/bin/activate"

# dynamic function
alias nosleep="caffeinate -d"
alias ctest="apit ShijiApiTest testCreateBooking"
alias cdc="git c feature/ROB-1071_Shiji_Group"

#setting or helper
alias aaa="cat ~/.zshrc"
alias hhh="head ~/.zshrc"
alias vimrc="vim ~/.zshrc"
alias sourcerc="source ~/.zshrc"
alias sail='./vendor/bin/sail'
alias dc="docker-compose"
alias dockerstart="colima start"
alias ll="ls -al"
alias gitadd="git add . && git reset todo.md note.md auth.json __temp app/Console/Commands/__temp docker-compose.yml docker"
alias gitstatus="git -c color.status=always status | grep --color=always  -v -e 'note\.md' -e 'todo\.md' -e 'auth.json' -e '__temp' -e 'docker'"


alias rimereload="(cd ~/Library/Rime && '/Library/Input Methods/Squirrel.app/Contents/MacOS/Squirrel' --reload)"


#cd 
alias cdapi="cd ~/git/kkday-b2b-api"
alias cdrbms="cd ~/git/kkday-RBMS"
alias cddemo="cd ~/git/kk-demo"
alias cdpsp="cd ~/git/kkday-psp"
alias cdtrade="cd ~/git/__personal/freqtrade"


#-- docker container related
#---- b2b api
alias apic="docker exec kkday-b2b-api-laravel.test-1"
alias apibash="docker exec -it kkday-b2b-api-laravel.test-1 bash"
alias apits="docker exec kkday-b2b-api-laravel.test-1 php artisan ts"
alias apiswagger="docker exec kkday-b2b-api-laravel.test-1 php artisan l5-swagger:generate"

alias pspbash="docker exec -it kkday-psp-laravel.test-1 bash"


# ------------- end of alias -----------

#show git branch
function parse_git_branch() {
    git branch 2> /dev/null | sed -n -e 's/^\* \(.*\)/[\1]/p'
}

COLOR_DEF=$'%f'
COLOR_USR=$'%F{243}'
COLOR_DIR=$'%F{197}'
COLOR_GIT=$'%F{39}'
setopt PROMPT_SUBST
export PROMPT='${COLOR_USR}%n ${COLOR_DIR}%~ ${COLOR_GIT}$(parse_git_branch)${COLOR_DEF} $ '


#brew
export PATH=/opt/homebrew/bin:$PATH

# git disable push origin
function git() {
    if [[ $1 == "push" && $2 == "origin" ]]; then
        echo "Error: git push origin is disabled."
        return 1
    else
        # Call the actual git command with the arguments
        command git "$@"
    fi
}


apiremote() {
  remoteInfo="$1"
  command=$(docker exec -t kkday-b2b-api-laravel.test-1 php artisan run:switchRemote --info="$1")
  eval $command
}

apit() {

    checkResult=$(docker exec -t kkday-b2b-api-laravel.test-1 php artisan run:testCheck) 
    
    echo "check result: $checkResult"
    if [[ $checkResult == *"error"* ]]; then
        echo "error test checking fail, aborting"
        exit 1
    fi

    if [ $# -eq 0 ]; then
        docker exec -t kkday-b2b-api-laravel.test-1 ./vendor/bin/phpunit --coverage-html coverage-report
    else
        original_file_name="$1"
        method="$2"
        coverage=""

        # 如果結尾不是 .php，則加上 .php
        if [[ ! "$original_file_name" =~ \.php$ ]]; then
            file_name="$original_file_name.php"
        else
            file_name="$original_file_name"
        fi

        # 如果結尾不是 Test.php，則在 .php 的前面加上 Test
        if [[ ! "$file_name" =~ Test\.php$ ]]; then
            file_name="${file_name%.*}Test.php"
        fi
         
        echo "file name: $file_name"
       
        
        if [[ "$file_name" == tests* ]]; then
            found_file=$file_name
        else
            found_file=$(find tests -type f -name "$file_name")
        fi


        echo "found_file: $found_file"

        echo "docker exec -t kkday-b2b-api-laravel.test-1 ./vendor/bin/phpunit $found_file"
        if [ -n "$found_file" ]; then
            if [ -n "$method" ]; then
                echo "case 1"
                # 如果有第二個參數 $method，則執行額外的 command
                docker exec -t kkday-b2b-api-laravel.test-1 ./vendor/bin/phpunit --filter "$method" "$found_file" 

            else
                echo "case 2"
                echo "$found_file"
                # 否則執行原本的 command
                docker exec -t kkday-b2b-api-laravel.test-1 ./vendor/bin/phpunit "$found_file"
                #docker exec -t kkday-b2b-api-laravel.test-1 ./vendor/bin/phpunit "$found_file" --coverage-html coverage-report
            fi
        else
            echo "File not found: $file_name"
            echo "\n------------"
        fi
    fi
}
export PATH="/opt/homebrew/opt/php@8.2/bin:$PATH"
alias python=python3

# Created by `pipx` on 2024-12-22 17:55:40
export PATH="$PATH:/Users/dave.lai/.local/bin"
```