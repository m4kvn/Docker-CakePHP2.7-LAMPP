FROM mariadb:10.1
MAINTAINER MasahiroSaito (m411momo)

# パスワード無しを許可
ENV MYSQL_ALLOW_EMPTY_PASSWORD=true

# 起動用スクリプトをコピー
COPY [ "./startup.sh", "/startup.sh" ]
RUN chmod +x /startup.sh

# バックアップ用フォルダの作成
# バックアップ用スクリプトの追加
RUN mkdir -p /root/mysql/backup
COPY [ "./backupmysql.sh", "/root/backupmysql.sh" ]
RUN chmod +x /root/backupmysql.sh

# cronのインストール
# cronの設定
RUN apt-get update -y
RUN apt-get install -y cron
RUN echo '0 0 * * * root /root/backupmysql.sh' > /etc/cron.d/backupmysql

CMD [ "/startup.sh" ]