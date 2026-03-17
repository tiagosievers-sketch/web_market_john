#!/bin/bash
set -e

# Use Railway's PORT or default to 8080
PORT="${PORT:-8080}"

# Laravel storage: create dirs at runtime (sessions, views, cache)
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Fix MPM: ensure only prefork is enabled (avoids "More than one MPM loaded")
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Apache: listen on dynamic port
echo "[entrypoint] PORT=${PORT}"
echo "Listen ${PORT}" > /etc/apache2/ports.conf
sed -i "s/8080/${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Debug
echo "[entrypoint] ports.conf:"
cat /etc/apache2/ports.conf
echo "[entrypoint] 000-default.conf (first 5 lines):"
head -5 /etc/apache2/sites-available/000-default.conf
echo "[entrypoint] apache2ctl configtest:"
/usr/sbin/apache2ctl configtest || true

exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
