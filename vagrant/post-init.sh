#!/bin/bash

WEB_DIR=/opt/DWI/src
DB_DIR=/opt/DWI/sql

# Setup Website

cd $WEB_DIR

composer install
php app/console assets:install --symlink

# Setup Database

cd $DB_DIR

mysql -uroot -pDiablo2 < db.sql
