#!/bin/sh

/opt/lampp/lampp start
echo "create database hakoeve " | /opt/lampp/bin/mysql -u root

trap_TERM() {
    echo 'SIGTERM ACCEPTED.'
    MSG=`/root/backupmysql.sh`
    echo $MSG
    exit 0
}

trap 'trap_TERM' TERM

while :
do
    sleep 5
done