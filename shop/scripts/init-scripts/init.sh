#!/bin/bash

if [ "$USE_DB_DUMP" -eq "1" ] ; then
  echo "@ Loading database dump..."
  mysql -uwloczki-user -pwloczki-password -h db wloczki-warmii < /tmp/sql/dump.sql
else
  echo "@ Skipping database loading"
fi

