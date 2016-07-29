HakoEve の WEB 開発環境を「Immutable Infrastructure（不変のインフラ）」化させるために、hakoeve の debug ブランチを元に作成した。新規のリポジトリを作成した理由としてし、debug ブランチの app/webroot/img のファイルが一部おかしかったので、そこを修正した状態で新たにリポジトリを作成する必要があったから。

HakoEve Web 開発環境の構築
--------------------------

1. [Docker for Mac](https://docs.docker.com/docker-for-mac/) をインストール
- Docker for Mac を起動
- master ブランチをクローン
- `chmod -R 777 hakoeve/` を実行
- `docker-compose up --build -d` で起動
- [http://localhost/](http://localhost/) にアクセス
- _phpMyAdmin_ にアクセス
- _hakoeve_ という名前でデータベースを作成
- _hakoeve_ にデータをインポートする
- [http://localhost/hakoeve/events](http://localhost/hakoeve/events) にアクセス
