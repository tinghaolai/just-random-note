<!--HugoNoteFlag-->

---


## Package Container


image name: myproject

* Commit current container
  * docker commit myproject myproject-container:1.0
* Export container to file
  * docker save -o test.tar myproject:1.0
* Import on another docker environment
  * docker load < test.tar
* Run container
  * docker run myproject:1.0


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 容器套件

圖像名稱：我的專案

* 提交當前容器
  * docker commit myproject myproject-container:1.0
* 將容器匯出為檔案
  * docker save -o test.tar myproject:1.0
* 在另一個 Docker 環境中匯入
  * docker load < test.tar
* 執行容器
  * docker run myproject:1.0