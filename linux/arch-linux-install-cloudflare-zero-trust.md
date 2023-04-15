<!--HugoNoteFlag-->

---


## arch linux install cloudflare zero trust

After install `warp-cli`, if you get `Cloudflare warp daemon error when register the client`, run `systemctl enable --now warp-svc.service`.

### Client register team

* run `warp-cli teams-enroll {teamName}`
* open url with firefox and copy token from console, which token start with "com.cloudflare.warp://".
* `warp-cli status`
* `warp-cli start`
* `warp-cli status`




---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 在 Arch Linux 安裝 Cloudflare Zero Trust

安裝完 `warp-cli` 後，若在註冊客戶端時遇到 `Cloudflare warp daemon error` 錯誤，可以執行 `systemctl enable --now warp-svc.service` 命令。

### 客戶端註冊團隊

* 執行命令 `warp-cli teams-enroll {團隊名稱}`
* 用 Firefox 開啟 URL，從控制台複製 token，token 以 "com.cloudflare.warp://" 開頭。
* 執行命令 `warp-cli status`
* 執行命令 `warp-cli start`
* 執行命令 `warp-cli status`