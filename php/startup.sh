#!/bin/bash

service mysql start

echo "create database hakoeve" | mysql -u root

apache2-foreground