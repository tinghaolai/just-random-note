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