FROM prestashop/prestashop:1.7.8

COPY scripts /tmp
COPY dump.sql /tmp/sql/dump.sql

RUN chmod +x /tmp/post-install-scripts/post-install.sh && chmod +x /tmp/init-scripts/init.sh && chmod +x /tmp/pre-install-scripts/pre-install.sh

COPY img /var/www/html/img
