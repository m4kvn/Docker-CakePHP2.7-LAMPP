#!/bin/sh

# バックアップ用ディレクトリの指定
dirpath='/root/mysql/backup'

# ファイル名を指定
filename=`date +%y%m%d-%H%M%S`

# データベースのバックアップ
mysqldump --user root hakoeve > $dirpath/$filename.sql

# パーミッションを変更
chmod 700 $dirpath/$filename.sql

# 30日以上前のバックアップを削除
find /root/mysql/backup -mtime +30 -exec rm -f {} \;