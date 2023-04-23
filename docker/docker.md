<!--HugoNoteFlag-->

---

## Access container using bash

After enter container terminal, type `/bin/bash` to access bash.

If u want to make it convenient, execute it with container script.

> e.g. In Tabby terminal add new cmd config, and set `cmd.exe /c 'docker exec -it php-74 bash'` command when config open. (`php-74` is container name or container alias)


## Call container uri in local

Each container can be access with container's external port with domain: `host.docker.internal`

For example:

* Api url `http://host.docker.internal:8016/api/member/create`
* .env connection
    ```
    REDIS_HOST=host.docker.internal
    REDIS_PASSWORD=
    REDIS_PORT=6379
    REDIS_CACHE_DB=1
    ```

## Call container inside another container

[Solution](https://stackoverflow.com/questions/42385977/accessing-a-docker-container-from-another-container)

Create network and connect containers u want them connected, and inspect their setting.

> Note that ip could be changed after docker restarted.

### Open exists container

docker start broker

### Create new container (with network and static IP)

docker run --net developer-network --ip 172.25.0.9 -it confluentinc/cp-kafka:5.3.1 bash

## Docker bridge network fixed ip

As I know, can't assign static IP to exists container, have to create new one.

[Solution](https://stackoverflow.com/questions/27937185/assign-static-ip-to-docker-container)

## Change password

This happened to my side project, because it's testing at beginning,

so I use default password.

But then I think it's not safe, 

so I change it in `docker-compose.yml`,

but `docker-compose up -d` not work,

since the relate data is in volume,

so I decide to remove the volume and recreate it,

But then I realize that I should just change the account setting in container.


```bash



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 透過 bash 存取容器 

進入容器終端機後，輸入 `/bin/bash` 以存取 bash 。

如果您想方便些，可以使用容器指令來執行。

> 例如 在 Tabby 終端機中增加新的指令配置，在設定打開時以 `cmd.exe /c 'docker exec -it php-74 bash'` 命令配置。( `php-74` 是容器名稱或容器別名 ) 


## 在本地環境中調用容器 URI

每個容器都可以通過其埠號與域名進行存取： `host.docker.internal`

例如：

* API 位址 `http://host.docker.internal:8016/api/member/create`
* .env 連接
    ```
    REDIS_HOST=host.docker.internal
    REDIS_PASSWORD=
    REDIS_PORT=6379
    REDIS_CACHE_DB=1
    ```

## 在另一個容器內部呼叫容器

[解決方法](https://stackoverflow.com/questions/42385977/accessing-a-docker-container-from-another-container)

建立網路，連接您想要連接的容器，並檢查其設置。

> 請注意，IP 可能會在 Docker 重新啟動後更改。

### 開啟現有的容器

docker start broker

### 建立新的容器(帶有網路和固定 IP)

docker run --net developer-network --ip 172.25.0.9 -it confluentinc/cp-kafka:5.3.1 bash

## Docker 橋接網路固定 IP

據我所知，無法為現有容器分配固定 IP，必須創建新的容器。

[解決方法](https://stackoverflow.com/questions/27937185/assign-static-ip-to-docker-container)

## 更改密碼

這發生在我的副業項目中，因為一開始是進行測試，所以我使用預設密碼。

但後來我覺得不安全，就在 `docker-compose.yml` 中修改了密碼。

但是， `docker-compose up -d` 沒有發揮作用，因為相關的數據是在卷中，

所以我決定刪除卷並重新創建它，但後來我意識到應該只需更改容器中的帳戶設置。