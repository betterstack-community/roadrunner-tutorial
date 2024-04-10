FROM composer:2.7.2 AS composer
FROM ghcr.io/roadrunner-server/roadrunner:2023.3.12 AS roadrunner
FROM php:8.3.4-cli-bookworm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends unzip; \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install sockets
