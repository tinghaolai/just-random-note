<!--HugoNoteFlag-->

---

warp-cli teams-enroll <TeamName>

Will make you open browser `https://<Team>.cloudflareaccess.com/warp`

but what if your server is not a desktop?

## Solution

Open the url within a browser on your desktop which is logged in to the same account,

and copy the token from console.

back to your server, 

run `warp-cli teams-enroll-token com.cloudflare.warp://<Team>.cloudflareaccess.com/auth?token=XXXXXXXXXXXXXXXXX`

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

warp-cli teams-enroll <TeamName>

會開啟瀏覽器 `https://<Team>.cloudflareaccess.com/warp`

但如果您的伺服器不是桌面呢？

## 解決方案

在已經登入同一帳戶的桌面瀏覽器中打開此網址，

從控制台複製 token。

回到您的伺服器，

運行 `warp-cli teams-enroll-token com.cloudflare.warp://<Team>.cloudflareaccess.com/auth?token=XXXXXXXXXXXXXXXXX`。