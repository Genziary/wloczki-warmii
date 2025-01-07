#!/bin/bash

echo "@ Initializing database with dump file..."

mysql -u"$DB_USER" -p"$DB_PASSWD" -h"$DB_SERVER" "$DB_NAME" < /tmp/sql/dump.sql
