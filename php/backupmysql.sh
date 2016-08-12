#!/bin/sh

# バックアップ保存用ディレクトリの指定
dirpath='/root/mysql/backup'

# ファイル名を指定する(※ファイル名で日付がわかるようにしておきます)
filename=`date +%y%m%d-%H%M%S`

# 指定したDBのスキーマおよびデータをすべて吐き出す
mysqldump --user root hakoeve > $dirpath/$filename.sql

# パーミッション変更
chmod 700 $dirpath/$filename.sql