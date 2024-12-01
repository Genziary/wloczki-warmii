FROM prestashop/prestashop:1.7.8

COPY ../config/scripts /tmp
COPY shop/dump.sql /tmp/sql/dump.sql
COPY ../config/certs/certificate.crt /etc/ssl/certs/
COPY ../config/certs/private.key /etc/ssl/private/
COPY ../config/conf/default-ssl.conf /etc/apache2/sites-available/

RUN a2enmod ssl
RUN a2ensite default-ssl

RUN chmod +x /tmp/post-install-scripts/post-install.sh && chmod +x /tmp/init-scripts/init.sh && chmod +x /tmp/pre-install-scripts/pre-install.sh

COPY shop/img /var/www/html/img
