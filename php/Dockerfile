FROM php:5.5.38-apache
MAINTAINER MasahiroSaito (m411momo)

# PHP データベース設定
RUN apt-get update -y
RUN docker-php-ext-install pdo_mysql mbstring mysqli
ADD [ "cakephp.conf", "/etc/apache2/conf-enabled/cakephp.conf" ]
ADD [ "php.ini", "/etc/php5/apache2/php.ini" ]

# MariaDB インストール
RUN apt-get install -y software-properties-common
RUN apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db
RUN add-apt-repository 'deb http://ftp.yz.yamagata-u.ac.jp/pub/dbms/mariadb/repo/10.0/ubuntu trusty main'
RUN apt-get update -y
RUN apt-get install -y expect

# expect を使ってインストールを続ける
ADD [ "db_install.exp", "/db_install.exp" ]
RUN expect /db_install.exp

# phpmyadmin インストール
ADD [ "phpmyadmin_install.exp", "/phpmyadmin_install.exp" ]
RUN expect /phpmyadmin_install.exp
ADD [ "config.inc.php", "/etc/phpmyadmin/config.inc.php" ]

# バックアップ用フォルダの作成
# バックアップ用スクリプトの追加
RUN mkdir -p /root/mysql/backup
COPY [ "./backupmysql.sh", "/root/backupmysql.sh" ]
RUN chmod +x /root/backupmysql.sh

# cronのインストール
# cronの設定
RUN apt-get install -y cron
RUN echo '0 0 * * * root /root/backupmysql.sh' > /etc/cron.d/backupmysql

ADD [ "startup.sh", "/startup.sh" ]
RUN chmod +x /startup.sh
ENTRYPOINT [ "/startup.sh" ]