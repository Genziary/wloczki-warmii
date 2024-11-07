#!/bin/bash

echo "@ Initializing database with dump file..."

mysql -uwloczki-user -pwloczki-password -h db wloczki-warmii < /tmp/sql/dump.sql
