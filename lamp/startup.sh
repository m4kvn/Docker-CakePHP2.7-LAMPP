#!/bin/bash

service mysql start

trap_TERM() {
    echo 'SIGTERM ACCEPTED.'
    MSG=`/root/backupmysql.sh`
    echo $MSG
    exit 0
}

trap 'trap_TERM' TERM

apache2-foreground&

while :
do
    sleep 5
done