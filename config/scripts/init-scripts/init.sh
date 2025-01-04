#!/bin/bash

echo "@ Checking for memcached extension..."
if ! php -m | grep -q memcached; then
  echo "@ Installing memcached extension..."

  # Update package list and install prerequisites
  apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

  echo "@ Memcached extension installed."
else
  echo "@ Memcached extension already installed."
fi

if [ "$USE_DB_DUMP" -eq "1" ] ; then
  echo "@ Loading database dump..."
  mysql -uwloczki-user -pwloczki-password -h db wloczki-warmii < /tmp/sql/dump.sql
else
  echo "@ Skipping database loading"
fi

echo "@ Setting theme permissions..."
chmod -R 777 /var/www/html/themes
