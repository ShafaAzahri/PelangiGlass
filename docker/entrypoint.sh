#!/bin/sh
set -e

mkdir -p \
    /app/storage/framework/cache/data \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/logs \
    /app/bootstrap/cache

# Wait for PostgreSQL if DB_CONNECTION is pgsql
if [ "${DB_CONNECTION:-pgsql}" = "pgsql" ]; then
    echo "Waiting for PostgreSQL at ${DB_HOST:-postgres}:${DB_PORT:-5432}..."
    until php -r "try { new PDO('pgsql:host=' . (getenv('DB_HOST') ?: 'postgres') . ';port=' . (getenv('DB_PORT') ?: '5432') . ';dbname=' . (getenv('DB_DATABASE') ?: 'pelangiglass'), getenv('DB_USERNAME') ?: 'pelangiglass', getenv('DB_PASSWORD') ?: 'secret'); exit(0); } catch (Throwable \$e) { exit(1); }" 2>/dev/null; do
        sleep 1
    done
    echo "PostgreSQL is ready."
fi

# Storage symlink
if [ ! -L /app/public/storage ]; then
    php artisan storage:link --force || true
fi

# Run migrations
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    php artisan migrate --force --no-interaction
fi

# Cache config, routes, and views in production
if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan optimize --no-interaction || true
    php artisan filament:optimize --no-interaction || true
fi

exec frankenphp run --config /etc/caddy/Caddyfile
