[[ -o interactive ]] || return
setopt prompt_subst

autoload -Uz colors && colors

# =========================
# Cyberpunk 霓虹色調
# =========================
local neon_green="%F{46}"   # ❯
local cyan="%F{51}"         # 路徑青藍
local magenta="%F{201}"     # Branch 名亮粉紫
local yellow="%F{226}"      # 命令字亮黃
local green="%F{46}"        # staged
local orange="%F{214}"      # dirty
local gray="%F{240}"        # 時間灰
local reset="%f"

# =========================
# Git branch 狀態
# =========================
function git_prompt_info() {
  local repo_root ref branch tag commit staged display

  # 確認是否是 git repo
  repo_root=$(git rev-parse --git-dir 2>/dev/null) || return

  # 取得 commit ID
  commit=$(git rev-parse --short HEAD 2>/dev/null)

  # 取得 tag（不一定存在）
  tag=$(git describe --tags --exact-match 2>/dev/null)

  # 取得 branch ref
  ref=$(git symbolic-ref -q HEAD 2>/dev/null)

  if [[ -n "$ref" ]]; then
    # 正常 branch
    branch=${ref#refs/heads/}

    # 如果 branch 有 tag 指向同一個 commit → 也同時顯示 tag
    if [[ -n "$tag" ]]; then
      display=" ${branch} | tag: ${tag} @ ${commit}"
    else
      display=" ${branch}"
    fi
  else
    # detached HEAD
    if [[ -n "$tag" ]]; then
      # 在 tag → 顯示 tag + commit
      display=" tag: ${tag} @ ${commit}"
    else
      # 純 commit（沒有 tag）
      display=" commit: ${commit}"
    fi
  fi

  # staged (+)
  if [[ -n "$(git diff --cached --name-only 2>/dev/null)" ]]; then
    staged="${green}+"
  fi

  echo " ${magenta}${display}${staged}${reset}"
}



# =========================
# Prompt 主題
# =========================
PROMPT=$'%{$neon_green%}❯%{$reset%} %{$cyan%}%~%{$reset%}$(git_prompt_info)\n%{$yellow%}$ %{$reset%}'
RPROMPT='%{$gray%}%D{%H:%M:%S}%{$reset%}'
typeset -g ZLE_RPROMPT_INDENT=0
PROMPT_EOL_MARK=''