#!/bin/sh
set -e

cd /var/www/html

# --- Wait for MySQL ---
echo "⏳ Waiting for database to be ready..."
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'OK'; } catch (Exception \$e) { exit(1); }"; do
  echo "  Database not ready yet, retrying in 3s..."
  sleep 3
done
echo "✅ Database is ready!"

if [ "$RUN_MIGRATIONS" = "true" ]; then

  # --- Composer dependencies ---
  if [ -f composer.json ] && [ ! -f vendor/autoload.php ]; then
    echo "🔧 Installing composer dependencies..."
    composer install --no-interaction --prefer-dist
  fi

  if ! php artisan key:generate --show > /dev/null 2>&1; then
    echo "⚙️  Generating APP_KEY..."
    php artisan key:generate --force
  fi
  echo "🗄️  Running migrations and seeders..."
  php artisan migrate --force || true
  if [ "$APP_ENV" = "local" ]; then
    php artisan db:seed --force || true
  fi
fi

while [ ! -f vendor/autoload.php ]; do
  echo "  Dependencies not installed yet, retrying in 3s..."
  sleep 3
done

# --- Choose mode ---
if [ "$APP_ROLE" = "queue" ]; then
  echo "🚀 Starting queue worker..."
  exec php artisan queue:work --tries=3 --timeout=90
elif [ "$APP_ROLE" = "scheduler" ]; then
  echo "⏰ Starting scheduler..."
  while true; do
    php artisan schedule:run --verbose --no-interaction
    sleep 60
  done
else
  echo "✅ Starting php-fpm..."
  exec php-fpm
fi

# --- Cache config/routes to improve perf (optional) ---
echo "🚀 Caching configuration..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache || true


echo "✅ Ready. Starting php-fpm..."
exec php-fpm
