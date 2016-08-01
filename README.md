HakoEve の WEB 開発環境を「Immutable Infrastructure（不変のインフラ）」化させるために、Docker を用いた XAMPP 環境を構築する。

構築手順
========

初回
----

**初回起動時はプルやビルドをするので時間がかかる**

1. [Docker for Mac](https://docs.docker.com/docker-for-mac/) をインストール
1. Docker for Mac を起動
1. hakoeve の environment ブランチを HakoEve_Environment 内にクローン
1. `chmod -R 777 hakoeve/app/tmp/` を実行
1. `chmod -R 777 hakoeve/app/Config/` を実行
1. HakoEve_Environment ディレクトリ内へ移動
1. `docker-compose up --build -d` で XAMPP を起動
1. [http://localhost/](http://localhost/) にアクセス
1. _phpMyAdmin_ にアクセス
1. _hakoeve_ という名前でデータベースを作成
1. _hakoeve_ にデータをインポートする
1. [http://localhost/hakoeve/events](http://localhost/hakoeve/events) にアクセス

初回以降
--------

1. HakoEve_Environment ディレクトリ内へ移動
1. `docker-compose up --build -d` で XAMPP を起動
1. [http://localhost/](http://localhost/) にアクセス
1. _phpMyAdmin_ にアクセス
1. _hakoeve_ という名前でデータベースを作成
1. _hakoeve_ にデータをインポートする
1. [http://localhost/hakoeve/events](http://localhost/hakoeve/events) にアクセス

お願い
======

**使いづらい点や要望・意見は issue の方にガンガンあげてください**