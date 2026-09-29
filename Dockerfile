# ==============================================================================
# Stage 1: Frontend Asset Build (Vite + Tailwind CSS)
# ==============================================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# ==============================================================================
# Stage 2: PHP Composer Dependencies (No-Dev, Optimized Autoloader)
# ==============================================================================
FROM dunglas/frankenphp:1-php8.4-alpine AS vendor

WORKDIR /app

RUN install-php-extensions \
    pdo_pgsql \
    intl \
    zip \
    gd \
    bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# ==============================================================================
# Stage 3: Lightweight Production Runtime (FrankenPHP Alpine)
# ==============================================================================
FROM dunglas/frankenphp:1-php8.4-alpine AS production

LABEL maintainer="Pelangi Glass Purwokerto"

WORKDIR /app

# Install only required runtime extensions and strip build artifacts in one layer
RUN install-php-extensions \
    pdo_pgsql \
    intl \
    zip \
    gd \
    bcmath \
    opcache \
    && rm -rf /tmp/* /var/cache/apk/*

# Copy low-memory PHP & FrankenPHP Caddy configurations
COPY docker/php.ini /usr/local/etc/php/conf.d/99-custom.ini
COPY docker/Caddyfile /etc/caddy/Caddyfile
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application code
COPY . /app

# Copy production vendor & compiled frontend assets from build stages
COPY --from=vendor /app/vendor /app/vendor
COPY --from=frontend /app/public/build /app/public/build

# Prepare storage directories & publish Filament static assets
RUN mkdir -p \
    /app/storage/framework/cache/data \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/logs \
    /app/bootstrap/cache \
    && php artisan package:discover --ansi \
    && php artisan filament:assets --ansi \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
