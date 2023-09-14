## Zip upload cloud storage sync

### Feature

User has a folder with html and images, 

image in html is relative path, 

user can upload zip file to server, 

server will unzip and sync to cloud storage, 

and return html with cloud storage url.

### Issue

If too many images,

it will take too long to upload to cloud storage,

this will cause timeout.

### Solution

Temporarily save images to local storage,

and sync to cloud storage in background,

when sync is done,

replace local storage url with cloud storage url.