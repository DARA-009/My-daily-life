# ===================================================
# Stage 1: Build Frontend Assets (Vite + Tailwind v4)
# ===================================================
FROM node:20-bookworm-slim AS frontend
WORKDIR /app

# Install dependencies first for better caching
COPY package*.json ./
RUN npm ci

# Copy project files for Tailwind CSS v4 template scanning
COPY . .
RUN npm run build

# ===================================================
# Stage 2: Production PHP-FPM + Nginx
# ===================================================
FROM php:8.4-fpm-bookworm

ENV DEBIAN_FRONTEND=noninteractive

# Install system packages & PHP extension build dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    ca-certificates \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        intl \
        zip \
        bcmath \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy compiled frontend assets from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Install PHP production dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Configure storage permissions
RUN mkdir -p /var/www/html/storage/framework/cache/data \
             /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration and entrypoint
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose ports for Railway
EXPOSE 9000 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
