#!/bin/bash

echo "@ Initializing database with dump file..."

mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" "$DB_NAME" < /tmp/sql/dump.sql

echo "@ Enabling cache..."

sed -i "s/'ps_caching' => 'CacheMemcache'/'ps_caching' => 'CacheMemcached'/" /var/www/html/app/config/parameters.php
sed -i "s/'ps_cache_enable' => false/'ps_cache_enable' => true/" /var/www/html/app/config/parameters.php
