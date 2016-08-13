#!/bin/bash
mysql_install_db
service mysql start
apache2-foreground