FROM php:8.5-fpm-alpine

WORKDIR /var/www/html

# Instal dependensi sistem & ekstensi PHP yang dibutuhkan Laravel + PostgreSQL
RUN apk add --no-cache \
    postgresql-libs \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libpng-dev \
    libxml2-dev \
    && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    postgresql-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    intl \
    mbstring \
    gd \
    bcmath \
    opcache \
    && apk del .build-deps

# Copy seluruh project Laravel dari folder lokal 'laravel/' ke dalam container
COPY laravel/ /var/www/html/

# Atur permission untuk storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]