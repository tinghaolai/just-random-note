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
      * SSG through local IP, but can not connect with public IP, sometimes you want to receive webhook, then this solution can not satisfy this need, or when you want to WFM and deploy some service for your own app.
    * Public IP - router forwarding
      * Only router has public IP, make router forwarding to local IP (which is your server), but it's not allowed if you didnt own the network.
    * Ngrok or other service  
      * maybe a good solution, but has a rate limit and maybe the service abort.
    * Self frp service
      * Use another cloud server to build your own frp service, and you can build frp service through free cloud machine mention above. 

### My choice

Personally build a frp service through aws ec2 instance and connect to an old laptop, which install with ubuntu server, And local use windows laptop, and I'll replace ubuntu laptop with mini-pc if current CPU is not good enough for my dev/self-service condition.