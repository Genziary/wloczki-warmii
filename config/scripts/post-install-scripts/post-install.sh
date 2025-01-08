#!/bin/bash

echo "@ Initializing database with dump file..."

mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" "$DB_NAME" < /tmp/sql/dump.sql

echo "@ Updating shop url..."

mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" -e "UPDATE ps_configuration SET value = \"$PS_DOMAIN\" WHERE name LIKE \"%SHOP_DOMAIN%\"" "$DB_NAME" 
mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" -e "UPDATE ps_shop_url SET domain = \"$PS_DOMAIN\", domain_ssl = \"$PS_DOMAIN\" WHERE id_shop = 1" "$DB_NAME" 

echo "@ Enabling cache..."

sed -i "s/'ps_caching' => 'CacheMemcache'/'ps_caching' => 'CacheMemcached'/" /var/www/html/app/config/parameters.php
sed -i "s/'ps_cache_enable' => false/'ps_cache_enable' => true/" /var/www/html/app/config/parameters.php
