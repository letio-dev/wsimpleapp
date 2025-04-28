# ---------------------------------
# STAGE 1: Install PHP dependencies
# ---------------------------------
FROM php:8.4-fpm AS php-builder

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libxml2-dev libpng-dev \
    libpq-dev libonig-dev libgd-dev tesseract-ocr \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip xml gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# RUN php artisan config:cache && \
#     php artisan route:cache && \
#     php artisan view:cache

# ---------------------------------
# STAGE 2: Build Frontend with Vite
# ---------------------------------
FROM node:22-alpine AS vite-builder

WORKDIR /app
COPY . .

RUN npm install && npm run build

# ---------------------------------
# STAGE 3: Production PHP-FPM Image
# ---------------------------------
FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libpq-dev libxml2-dev libonig-dev libgd-dev tesseract-ocr \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip xml gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY --from=php-builder /var/www /var/www
COPY --from=vite-builder /app/public/build /var/www/public/build

RUN chown -R www-data:www-data /var/www \
    && chmod -R ug+w /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
