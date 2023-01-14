## MySQL reinstall

In you have an SQL got stuck, which could run for many days, and even the rollback operation would also take lots of time, so one solution is that reinstall the mysql.

### Uninstall stuck

When you uninstall mysql while running a stuck sql, `apt-get purge` will also be stuck.

**Solution**

Run `sudo killall -KILL mysql mysqld_safe mysqld`

### Uninstall scripts

* `apt-get purge --auto-remove mysql-common mysql-server mariadb-server`
* `apt-get autoremove`
* `apt-get autoclean`
* `rm -rm /var/lib/mysql`

### install scripts

* `apt-get install --reinstall mysql-server`