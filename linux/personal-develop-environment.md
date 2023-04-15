<!--HugoNoteFlag-->

---


## Personal develop environment

What's the suitable environment for personal develop environment? Here's my opinion. 

* Local pc / os-select
  * Windows
    * Develop environment sometimes have a lot of issue, many programmer not willing to use this os, but me personally will still choose Windows because of the game playing.
    * It's slow when using docker develop
  * MAC OS - didn't try it.
  * Linux-line - great if you used to it.
* Cloud develop (with Unix-like system, locally dev and auto upload file to remote server)
  * Small VPS
    * Cheap but still need to pay, still have bad performance with low price, and may have internet latency depends on different vendor.
  * GCP - don't have free machine
  * AWS ec2 - have free tier machine, but low RAM and storage is a problem.
  * Oracle cloud - Relative less user but free tier has bigger storage, and way bigger than AWS, which about 30G.
* Physical server (with Unix-like system)
  * Device choose
    * Laptop - not commend, you can buy better CPU in other option with same price, use you already have one old laptop, then you can install ubuntu server on it.
    * PC / slim PC - too big for me on a small desk
    * mini PC - Can still have a great CPU with the price not too high, and RAM/storage are also extendable.
  * Remote connect type
    * Local IP
      * SSH through local IP, but can not connect with public IP, sometimes you want to receive webhook, then this solution can not satisfy this need, or when you want to WFM and deploy some service for your own app.
    * Public IP - router forwarding
      * Only router has public IP, make router forwarding to local IP (which is your server), but it's not allowed if you didnt own the network.
    * Ngrok or other service  
      * maybe a good solution, but has a rate limit and may broke the service.
    * Self frp service
      * Use another cloud server to build your own frp service, and you can build frp service through free cloud machine mention above. 

### My choice

Personally build a frp service through aws ec2 instance and connect to an old laptop, which install with ubuntu server, And local use windows laptop, and I'll replace ubuntu laptop with mini-pc if current CPU is not good enough for my dev/self-service condition.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 個人開發環境

什麼是適合個人開發環境的環境？這是我的觀點。

* 本機電腦/操作系統選擇
  * Windows
    * 開發環境有很多問題，很多程式設計師不願意使用這個操作系統，但我個人仍然會選擇 Windows，因為我喜歡玩遊戲。
    * 使用 Docker 開發時速度較慢
  * MAC OS - 沒試過。
  * Linux 系統 - 如果你習慣了使用它，那很不錯。
* 雲端開發（使用類 Unix 系統，在本地開發並自動上傳文件到遠程服務器）
  * 小 VPS
    * 便宜但仍需支付費用，價格低廉的性能仍然很差，可能會有不同供應商的網絡延遲。
  * GCP - 沒有免費機器
  * AWS ec2 - 有免費機器，但內存和存儲是問題。
  * Oracle cloud - 相對來說用戶較少，免費試用版本有更大的存儲容量，比 AWS 要大很多，約為 30G。
* 物理服務器（使用類 Unix 系統）
  * 設備選擇
    * 筆記本電腦 - 不推薦，你可以花同樣的價格在其他選項上購買更好的 CPU，如果你已經有一台舊的筆記本電腦，那麼你可以在上面安裝 ubuntu server。
    * 台式機/超機 - 太大了，不適合放在小桌子上
    * 迷你電腦 - 可以帶有很好的 CPU，價格不太高，RAM/存儲量也可以擴展。
  * 遠程連接類型
    * 本地 IP
      * 通過本地 IP 進行 SSH，但無法使用公共 IP 連接，有時你想接收 webhook，那麼這個解決方案無法滿足這個需求，或者當你想 WFM 和部署一些你自己的應用程序服務時。
    * 公共 IP - 路由器轉發
      * 只有路由器具有公共 IP，所以必須將路由器轉發到本地 IP（即您的服務器），但未獲得網絡許可的情況下無法使用此功能。
    * Ngrok 或其他服務
      * 可能是一個好的解決方案，但有速率限制，可能會破壞服務。
    * 自己的 frp 服務
      * 使用另一個雲服務器來構建自己的 frp 服務，你可以通過免費的雲端機器構建 frp 服務，如上所述。

### 我的選擇

我個人選擇通過 AWS ec2 實例搭建一个 frp 服務，並連接到一台安裝了 ubuntu server 的舊筆記本電腦上，本地則使用 Windows 筆記本電腦，如果當前 CPU 的性能不夠好，我會用一台迷你電腦來替換我的 ubuntu 筆記本電腦。