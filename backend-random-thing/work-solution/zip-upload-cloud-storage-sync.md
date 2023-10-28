<!--HugoNoteFlag-->

---

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

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 壓縮檔上傳的雲端儲存同步功能

### 功能

使用者有一個包含 HTML 和圖片的資料夾，

HTML 中的圖片使用相對路徑，

使用者可以將壓縮檔上傳至伺服器，

伺服器將解壓縮並同步到雲端儲存，

並返回包含雲端儲存網址的 HTML。

### 問題

如果圖片過多，

上傳到雲端儲存會花費太長時間，

可能導致逾時。

### 解決方案

暫時將圖片儲存到本地儲存空間，

並在背景中同步到雲端儲存，

當同步完成時，

用雲端儲存的網址替換本地儲存的網址。