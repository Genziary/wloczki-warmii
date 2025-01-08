#!/bin/bash

if [ "$USE_DB_DUMP" -eq "1" ] ; then
  echo "@ Loading database dump..."
  mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" "$DB_NAME" < /tmp/sql/dump.sql

  echo "@ Updating shop url..."
  mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" -e "UPDATE ps_configuration SET value = \"$PS_DOMAIN\" WHERE name LIKE \"%SHOP_DOMAIN%\"" "$DB_NAME" 
  mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" -e "UPDATE ps_shop_url SET domain = \"$PS_DOMAIN\", domain_ssl = \"$PS_DOMAIN\" WHERE id_shop = 1" "$DB_NAME" 
else
  echo "@ Skipping database loading"
fi

echo "@ Setting theme permissions..."
chmod -R 777 /var/www/html/themes

