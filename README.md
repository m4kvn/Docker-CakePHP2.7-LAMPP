HakoEve の WEB 開発環境を「Immutable Infrastructure（不変のインフラ）」化させるために、Docker を用いた XAMPP 環境を構築する。

HakoEve Web 開発環境の構築手順
------------------------------

**初回起動時はプルやビルドをするので時間がかかる**

1. [Docker for Mac](https://docs.docker.com/docker-for-mac/) をインストール
- Docker for Mac を起動
- hakoeve の environment ブランチを HakoEve_Environment 内にクローン
- `chmod -R 777 hakoeve/app/tmp/` を実行
- `chmod -R 777 hakoeve/app/Config/` を実行
- HakoEve_Environment ディレクトリ内へ移動
- `docker-compose up --build -d` で XAMPP を起動
- [http://localhost/](http://localhost/) にアクセス
- _phpMyAdmin_ にアクセス
- _hakoeve_ という名前でデータベースを作成
- _hakoeve_ にデータをインポートする
- [http://localhost/hakoeve/events](http://localhost/hakoeve/events) にアクセス

お願い
------

**使いづらい点や要望・意見は issue の方にガンガンあげてください**