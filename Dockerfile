FROM php:8.3-cli

# Устанавливаем утилиты, libcurl и расширения PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    && docker-php-ext-install zip curl \
    && rm -rf /var/lib/apt/lists/*

# Ставим composer из официального образа
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

