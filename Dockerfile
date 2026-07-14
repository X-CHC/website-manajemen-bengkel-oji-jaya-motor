# ---------- Build Frontend ----------
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# ---------- Build Laravel ----------
FROM dunglas/frankenphp:1.5-php8.2

RUN install-php-extensions \
    pdo_mysql \
    zip \
    mbstring \
    bcmath \
    intl \
    gd \
    exif \
    pcntl \
    opcache

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-80}
