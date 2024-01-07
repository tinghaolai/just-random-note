<!--HugoNoteFlag-->

---

## Example

* VM: aws ec2
* Local machine: real machine to serve web service
* Proxy: frp
* Domain: namecheap
* Web: docker laravel
* SSL: cloudflare - flexible

## Settings

* DNS: Set subdomain in cloudflare to point to aws ec2 IP/CNAME
* Register nameservers in namecheap
* Local machine use frp client to proxy web service (docker laravel with any port) from aws ec2 with 80 port
* Enter subdomain in browser with https://

> Browser(443) -> Namecheap -> cloudflare -> aws ec2(80) -> frp(80 mapping to (8305)) -> local machine(8305) -> docker laravel (8305 mapping to 80)

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 範例

* VM：aws ec2
* 本地機器：實際用來提供網絡服務的機器
* 代理：frp
* 域名：namecheap
* 網絡：docker laravel
* SSL：cloudflare - 可彈性選擇

## 設定

* DNS：在cloudflare上設定子域名指向aws ec2的IP/CNAME
* 在namecheap註冊Nameserver
* 本地機器使用frp客戶端從aws ec2代理網絡服務（docker laravel使用任意端口），將80端口映射到aws ec2
* 在瀏覽器中輸入https://開頭的子域名

> 瀏覽器（443）-> Namecheap -> cloudflare -> aws ec2（80）-> frp（80映射到8305）-> 本地機器（8305）-> docker laravel（8305映射到80）