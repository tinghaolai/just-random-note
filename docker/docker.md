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



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 透過 bash 存取容器

在進入容器終端機後，輸入 `/bin/bash` 以存取 bash。

若想要方便，在容器腳本中執行它。

> 例如，在 Tabby 終端機中新增 cmd 設定，並在設定打開時使用 `cmd.exe /c 'docker exec -it php-74 bash'` 命令。（`php-74` 是容器名稱或容器別名）

## 於本機中呼叫容器 uri

每個容器都可以使用容器的外部端口與域名 `host.docker.internal` 存取。

例如：

* API URL `http://host.docker.internal:8016/api/member/create`
* .env 連線
    ```
    REDIS_HOST=host.docker.internal
    REDIS_PASSWORD=
    REDIS_PORT=6379
    REDIS_CACHE_DB=1
    ```

## 在另一個容器內部呼叫容器

[解決方案](https://stackoverflow.com/questions/42385977/accessing-a-docker-container-from-another-container)

建立網路並連接要互相連接的容器，並檢查它們的設定。

> 請注意，容器重新啟動後 IP 可能會變更。

### 開啟現有容器

docker start broker

### 建立新的容器（與網路和靜態 IP 一起）

docker run --net developer-network --ip 172.25.0.9 -it confluentinc/cp-kafka:5.3.1 bash

## Docker 橋接網路固定 IP

據我所知，無法為現有容器指定靜態 IP，必須建立新的容器。

[解決方案](https://stackoverflow.com/questions/27937185/assign-static-ip-to-docker-container)