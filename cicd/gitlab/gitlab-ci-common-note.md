## Gitlab ci common note

* Pull image from gitlab
  * docker pull registry.gitlab.com/dave.lai/laravel-react-crawler/dave-test-image
    * `registry.gitlab.com` - gitlab site
    * `dave.lai` - owner or group
    * `laravel-react-crawler` - project name
* Use other image in image job: using [services](https://docs.gitlab.com/ee/ci/services/)

