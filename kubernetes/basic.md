<!--HugoNoteFlag-->

---

## Basic

After installed, run `kubectl get node`,

should be only one node, which is master node with role: `control-plane`.

## Errors

* Get `The connection to the server 192.168.1.101:6443 was refused - did you specify the right host or port?`
  * Try `sudo kubeadm init --pod-network-cidr=10.244.0.0/16 -v=9`
  * or `systemctl restart kubelet`
* Got too many errors event just start using it.
  * Tru another way, such as `MicroK8s`
* Try use `sudo -s` other than `sudo su -`

## Uninstall

```bash
kubeadm reset
sudo apt-get purge kubeadm kubectl kubelet kubernetes-cni kube*   
sudo apt-get autoremove  
sudo rm -rf ~/.kube
rm -rf /etc/kubernetes 
```

## Structure

![img.png](img.png)

## Install guide recommend

* kubeadm
  https://skyao.io/learning-kubernetes/docs/installation/kubeadm/ubuntu.html
* MicroK8s
  * Just follow the official guide, 
  * but somehow it became extremely slow after re-installed, I did all what I can do to entirely remove, but still.
* For ubuntu, really helpful tutorial
  * https://www.youtube.com/watch?v=7k9Rdlx30OY

## About multiple machines cluster from frp

Maybe i do something wrong, 

but i can't make it work,

so don't try it,

just use regular way.





---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 基本

安裝完成後，執行 `kubectl get node`，

應該只會有一個節點，即擔任 `control-plane` 角色的主節點。

## 錯誤

* 獲取 `The connection to the server 192.168.1.101:6443 was refused - did you specify the right host or port?` 的錯誤
  * 嘗試 `sudo kubeadm init --pod-network-cidr=10.244.0.0/16 -v=9`
  * 或 `systemctl restart kubelet`
* 只是開始使用，就出現過多的錯誤。
  * 嘗試使用其他方法，如 `MicroK8s`
* 嘗試使用 `sudo -s` 而不是 `sudo su -`

## 卸載

```bash
kubeadm reset
sudo apt-get purge kubeadm kubectl kubelet kubernetes-cni kube*   
sudo apt-get autoremove  
sudo rm -rf ~/.kube
rm -rf /etc/kubernetes 
```

## 結構

![img.png](img.png)

## 安裝指南推薦

* kubeadm
  https://skyao.io/learning-kubernetes/docs/installation/kubeadm/ubuntu.html
* MicroK8s
  * 只需遵循官方指南，
  * 但在重新安裝後，它某種程度上變得非常緩慢，我已盡全力完全卸載，但仍然如此。
* 對於 Ubuntu，非常有用的教程
  * https://www.youtube.com/watch?v=7k9Rdlx30OY

## 關於使用 frp 的多台機器叢集

也許我做錯了什麼，

但我無法讓其工作，

因此不要嘗試，

只需使用常規方式。