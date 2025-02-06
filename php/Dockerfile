FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y libxml2-dev libpng-dev libzip-dev

RUN docker-php-ext-install pdo pdo_mysql soap gd zip intl
ARG COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ALLOW_SUPERUSER=${COMPOSER_ALLOW_SUPERUSER}

ARG COMPOSER_AUTH='{"github-oauth":{"github.com":"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"}}'
ENV COMPOSER_AUTH=${COMPOSER_AUTH}

COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
