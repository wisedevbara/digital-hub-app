FROM php:8.5-fpm-alpine

RUN mkdir -p /workspace
WORKDIR  /workspace

# Instal library runtime yang dibutuhkan ekstensi PHP
RUN apk add --no-cache \
    postgresql-libs \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libpng-dev \
    libxml2-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev

# Instal build dependencies dan compile ekstensi
# CATATAN: opcache TIDAK diinstal terpisah karena sudah built-in di PHP 8.5
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        zip \
        intl \
        mbstring \
        gd \
        bcmath \
    && apk del .build-deps

COPY . /var/www/html
COPY laravel/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]