FROM php:7.4-fpm

# Install necessary extensions
RUN apt-get update && \
    apt-get install -y libxml2-dev libpng-dev libzip-dev imagemagick libmagickwand-dev

RUN docker-php-ext-install pdo pdo_mysql soap zip intl

RUN pecl install imagick && docker-php-ext-enable imagick

# Allow Composer in the container
ARG COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ALLOW_SUPERUSER=${COMPOSER_ALLOW_SUPERUSER}

ARG COMPOSER_AUTH='{"github-oauth":{"github.com":"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"}}'
ENV COMPOSER_AUTH=${COMPOSER_AUTH}

COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Ensure PHP-FPM listens on all interfaces
RUN sed -i "s/listen = \/run\/php\/php7.4-fpm.sock/listen = 9000/" /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm"]
