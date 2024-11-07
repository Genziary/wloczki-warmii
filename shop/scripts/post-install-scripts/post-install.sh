#!/bin/bash

echo "Loading database dump..."

mysql -uwloczki-user -pwloczki-password -h db wloczki-warmii < /tmp/sql/dump.sql
