FROM php:8.0-fpm-alpine

RUN apk --no-cache update
RUN apk --no-cache add --virtual .build-deps $PHPIZE_DEPS curl bash oniguruma-dev
RUN docker-php-ext-install pdo_mysql opcache mbstring
RUN curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk --no-cache add linux-headers
RUN pecl install xdebug-3.2.2 \
    && docker-php-ext-enable xdebug

RUN mkdir -p /shared/var/run
RUN chown www-data:www-data /shared/var/run
RUN rm /usr/local/etc/php-fpm.d/*docker.conf
ADD www.conf /usr/local/etc/php-fpm.d/www.conf
ADD custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN php -i
