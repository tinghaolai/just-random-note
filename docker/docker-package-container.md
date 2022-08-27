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