FROM prestashop/prestashop:1.7.8

COPY ../config/scripts /tmp
COPY shop/dump.sql /tmp/sql/dump.sql
COPY ../config/certs/certificate.crt /etc/ssl/certs/
COPY ../config/certs/private.key /etc/ssl/private/
COPY ../config/conf/default-ssl.conf /etc/apache2/sites-available/
COPY ../tests/test-memcache.php /var/www/html/test-memcache.php

RUN a2enmod ssl
RUN a2ensite default-ssl

RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

RUN chmod +x /tmp/post-install-scripts/post-install.sh && chmod +x /tmp/init-scripts/init.sh && chmod +x /tmp/pre-install-scripts/pre-install.sh

COPY --chmod=777 --chown=www-data:www-data shop/img /var/www/html/img
COPY --chmod=777 --chown=www-data:www-data shop/modules /var/www/html/modules
COPY --chmod=777 --chown=www-data:www-data shop/theme /var/www/html/themes/child_classic
