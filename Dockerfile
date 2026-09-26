FROM php:8.3.35-alpine3.23
RUN apk add --no-cache libpng-dev libzip-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip gd
COPY laravel/ /var/www/html/
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN if [ ! -f "composer.json" ]; then \
        composer create-project laravel/laravel:^12 . --prefer-dist --no-dev; \
    else \
        composer require laravel/framework:^12 --update-with-dependencies --prefer-dist; \
    fi
RUN composer install --no-dev --optimize-autoloader --prefer-dist || true
CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/html/public"]
