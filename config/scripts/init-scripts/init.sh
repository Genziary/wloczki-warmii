#!/bin/bash

if [ "$USE_DB_DUMP" -eq "1" ] ; then
  echo "@ Loading database dump..."
  mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" "$DB_NAME" < /tmp/sql/dump.sql
else
  echo "@ Skipping database loading"
fi

echo "@ Setting theme permissions..."
chmod -R 777 /var/www/html/themes

