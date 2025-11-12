# PHP 8.3 FPM + Composer + ext
FROM php:8.3-fpm-alpine

RUN apk add --no-cache git zip unzip curl libzip-dev oniguruma-dev icu-dev autoconf make g++ linux-headers \
 && docker-php-ext-install pdo pdo_mysql intl mbstring zip bcmath pcntl \
 && pecl install redis \
 && docker-php-ext-enable redis

RUN pecl install xdebug \
&& docker-php-ext-enable xdebug \
&& apk del autoconf make g++ linux-headers

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ARG PUID=1000
ARG PGID=1000

COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

RUN addgroup -g $PGID app && adduser -G app -g app -s /bin/sh -D -u $PUID app \
&& chown -R app:app /var/www/html
USER app

ENTRYPOINT ["entrypoint.sh"]
