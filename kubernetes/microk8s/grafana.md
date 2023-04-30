<!--HugoNoteFlag-->

---

## Install

` microk8s.enable dashboard prometheus`

## Open dashboard

* `microk8s kubectl get all --all-namespaces` to get IP
* open in browser
* enter password
  * getting from `microk8s config`
  * if it doesn't work, try `admin`, `admin`
  * or for me, user: `admin`, `prom-operator` works

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 安裝

`microk8s.enable dashboard prometheus`

## 開啟儀表板

* `microk8s kubectl get all --all-namespaces` 取得 IP
* 在瀏覽器中開啟
* 輸入密碼
  * 從 `microk8s config` 取得
  * 如果不能使用，試試 `admin`，`admin`
  * 或者對我來說，用戶名：`admin`，`prom-operator` 也可以工作。