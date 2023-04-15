<!--HugoNoteFlag-->

---

## Basic gitlab ci/cd test

### Installation 

Just follow the installation instructor in `Settings.CI/CD.Runners`, set up in your server.

### Setting files.

Create `.gitlab-ci.yml` file in the root of git project.


```yaml
stages:
  - build
  - deploy
build_job:
  stage: build
  script:
    - bash scripts/ci-test.sh
    - bash scripts/ci-test.sh
  tags:
    - tagA
deploy_job:
  stage: deploy
  script:
    - bash scripts/cd-test.sh
  tags:
    - tagA
```

> Runner will run stages, and every job of stage will run in each stage


Script example, create in folder `scripts`


**ci-test.sh**

```yaml
echo `date` >> /var/www/ci
```

write content in file `ci` on the server

**cd-test.sh**

```yaml
echo `date` >> /var/www/cd
```

write content in file `cd` on the server

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 基本的 gitlab ci/cd 測試

### 安裝

只需按照 `Settings.CI/CD.Runners` 中的安裝指示，在您的服務器上設置即可。

### 設置檔案

在 git 項目的根目錄中創建 `.gitlab-ci.yml` 文件。

```yaml
stages:
  - build
  - deploy
build_job:
  stage: build
  script:
    - bash scripts/ci-test.sh
    - bash scripts/ci-test.sh
  tags:
    - tagA
deploy_job:
  stage: deploy
  script:
    - bash scripts/cd-test.sh
  tags:
    - tagA
```

> Runner 將執行階段，每個階段的任務將在每個階段中運行。

腳本示例，創建在 `scripts` 文件夾中。

**ci-test.sh**

```yaml
echo `date` >> /var/www/ci
```

在服務器上的文件 `ci` 中寫入內容。

**cd-test.sh**

```yaml
echo `date` >> /var/www/cd
```

在服務器上的文件 `cd` 中寫入內容。
