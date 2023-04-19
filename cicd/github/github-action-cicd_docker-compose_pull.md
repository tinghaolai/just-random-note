<!--HugoNoteFlag-->

---

## Permission problem

* sudo groupadd docker
* sudo gpasswd -a $USER docker
  * sudo gpasswd -a deploy docker
* newgrp docker
* sudo systemctl restart docker


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 權限問題

* sudo groupadd docker
* sudo gpasswd -a $USER docker
  * sudo gpasswd -a deploy docker
* newgrp docker
* sudo systemctl restart docker