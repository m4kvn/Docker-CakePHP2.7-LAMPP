# 構築手順

HakoEve の WEB 開発環境を「Immutable Infrastructure（不変のインフラ）」化させるために、Docker を用いた XAMPP 環境を構築する。

## 前提

Docker を動かす環境は各自構築する必要がある
リンク先にインストール方法が記述されている

1. [Docker for Mac](https://docs.docker.com/docker-for-mac/) をインストール
1. Docker for Mac を起動

## 初回

**初回起動時はプルやビルドをするので時間がかかる**

1. *HakoEve_Environment* を適当な場所へクローン
1. *HakoEve_Environment* 内へ移動
1. `docker-compose build` でビルドを実行（時間がかかる）
1. 下記の **初回以降** を行う

## 初回以降

1. *HakoEve_Environment* 内へ移動
1. `docker-compose up -d` で起動
1. `docker-compose stop` で停止

## 説明

- *html* 内にファイルを配置する（*hakoeve* 等）
- *hakoeve* をクローンした場合 `localhost/hakoeve/events/` で接続できる
- `localhost/phpmyadmin/` で *phpMyAdmin* に接続できる