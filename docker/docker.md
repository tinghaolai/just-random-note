<!--HugoNoteFlag-->

---

## CMD vs RUN cs ENTRYPOINT

### CMD

```dockerfile
CMD ["executable","param1","param2"]
CMD command param1 param2
```

* Can only have one CMD, use last one
* Execute when container start

### ENTRYPOINT

* ENTRYPOINT should be defined when using the container as an executable.
  * instead of cmd
* Executed when container start

### RUN

* Can have multiple RUN
* Execute when building image
  * Will create a temporary container, execute command, and commit to image

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


## Output with color

* Has no color `alias apitest="docker exec api-laravel.test-1 ./vendor/bin/phpunit"`
* Has color `alias apitest="docker exec -t api-laravel.test-1 ./vendor/bin/phpunit"`

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## CMD與RUN與ENTRYPOINT的比較

### CMD

```dockerfile
CMD ["executable", "param1", "param2"]
CMD command param1 param2
```

* 只能有一個CMD，使用最後的
* 容器啟動時執行

### ENTRYPOINT

* 在把容器當作可執行文件時需要定義ENTRYPOINT
  * 而不是CMD
* 容器啟動時執行

### RUN

* 可以有多個RUN
* 在構建映像時執行
  * 會創建臨時容器，執行命令，然後提交到映像

## 使用bash訪問容器

在進入容器終端後，輸入`/bin/bash`以訪問bash。

如果希望更方便，可以使用容器腳本執行它。

> 例如，在Tabby終端中添加新的cmd配置，並在打開配置時設置`cmd.exe /c' docker exec -it php-74 bash'`命令（`php-74`是容器名稱或容器別名）


## 在本地呼叫容器URI

每個容器可以通過域`host.docker.internal`訪問容器的外部端口。

例如：

* API網址`http://host.docker.internal:8016/api/member/create`
* .env連接
    ```
    REDIS_HOST=host.docker.internal
    REDIS_PASSWORD=
    REDIS_PORT=6379
    REDIS_CACHE_DB=1
    ```

## 在另一個容器內呼叫容器

[解決方案](https://stackoverflow.com/questions/42385977/accessing-a-docker-container-from-another-container)

創建網絡並連接要連接的容器，並檢查它們的設置。

> 請注意，IP地址在Docker重新啟動後可能會更改。

### 打開現有容器

docker start broker

### 創建新容器（帶有網絡和靜態IP）

docker run --net developer-network --ip 172.25.0.9 -it confluentinc/cp-kafka:5.3.1 bash

## Docker橋接網絡固定IP

據我所知，無法為現有容器分配靜態IP，必須創建新容器。

[解決方案](https://stackoverflow.com/questions/27937185/assign-static-ip-to-docker-container)

## 更改密碼

這發生在我的副項目上，因為一開始正在測試，所以我使用的是默認密碼。

但是後來我認為這並不安全，

所以我在`docker-compose.yml`中修改它，

但是`docker-compose up -d`不起作用，

因為相關數據存儲在卷中，

所以我決定刪除該卷並重新創建它，

但後來我意識到我只需要修改容器中的帳戶設置即可。
