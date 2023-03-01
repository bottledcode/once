FROM php:8.2-apache AS build
# install extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer dom intl mbstring sodium zip uuid opcache apcu

# install composer dependencies
COPY composer.json composer.lock /var/www/
WORKDIR /var/www
RUN composer install --no-dev -o && a2enmod rewrite headers expires && \
    sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf

# install app
COPY html /var/www/html
COPY src /var/www/src

# update attributes mapping
RUN composer dump -o --apcu

FROM build AS css
# install tailwindcss and compile css
ADD --chmod=777 https://github.com/tailwindlabs/tailwindcss/releases/download/v3.2.7/tailwindcss-linux-x64 /usr/local/bin/twcss
COPY tailwind.config.js .
RUN twcss -i html/assets/main.css -o html/assets/compiled.css --minify

FROM build AS prod

# install compiled css
COPY --from=css /var/www/html/assets/compiled.css /var/www/html/assets/compiled.css

# update php.ini for production
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini && \
	echo "opcache.jit_buffer_size=100M" >> $PHP_INI_DIR/php.ini
