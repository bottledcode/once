FROM php:8.2-apache AS build
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer dom intl mbstring sodium zip uuid opcache apcu
COPY composer.json composer.lock /var/www/
WORKDIR /var/www
RUN composer install --no-dev -o && a2enmod rewrite headers expires && \
    sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf
COPY public /var/www/html
COPY src /var/www/src

RUN composer dump -o --apcu

FROM dunglas/frankenphp:latest AS dev

RUN install-php-extensions xdebug @composer dom intl mbstring sodium zip uuid && \
    echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.log = /tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

FROM build AS prod

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini && \
	echo "opcache.jit_buffer_size=100M" >> $PHP_INI_DIR/php.ini
