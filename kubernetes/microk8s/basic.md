## Open dashboard

* `microk8s kubectl get all --all-namespaces` to get IP of `service/kubernetes-dashboard`
* enter: `https://{ip}` in broswer
* Login with token
  * `token=$(microk8s kubectl -n kube-system get secret | grep default-token | cut -d " " -f1)
microk8s kubectl -n kube-system describe secret $token`


