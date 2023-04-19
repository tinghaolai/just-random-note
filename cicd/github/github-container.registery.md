<!--HugoNoteFlag-->

---

## GitHub Container Registry

**Your github project name**

https://github.com/davetestingaccount/test-for-ci

* Build image
  * `docker build -t local_image_name/test-for-ci:v0.1 .`
* Put tag
  * `docker tag local_image_name/test-for-ci:v0.1 ghcr.io/davetestingaccount/test-for-ci:v0.2`
* Login
  * `docker login ghcr.io -u davetestingaccount`
* Push to github
  * `docker push ghcr.io/<GITHUB_USERNAME><REPO_NAME>:<TAG>`
  * `docker push ghcr.io/davetestingaccount/test-for-ci:v0.2`
* Check upload
  * enter `ghcr.io/davetestingaccount/test-for-ci` in browser
    

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## GitHub容器註冊表

**您的GitHub專案名稱**

https://github.com/davetestingaccount/test-for-ci

* 建立映像檔
  * `docker build -t local_image_name/test-for-ci:v0.1 .`
* 加上標籤
  * `docker tag local_image_name/test-for-ci:v0.1 ghcr.io/davetestingaccount/test-for-ci:v0.2`
* 登入
  * `docker login ghcr.io -u davetestingaccount`
* 推送到GitHub
  * `docker push ghcr.io/<GITHUB_USERNAME><REPO_NAME>:<TAG>`
  * `docker push ghcr.io/davetestingaccount/test-for-ci:v0.2`
* 檢查上傳
  * 在瀏覽器中輸入 `ghcr.io/davetestingaccount/test-for-ci`。