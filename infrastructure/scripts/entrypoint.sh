#!/bin/bash
set -e

# Use Railway's PORT or default to 8080
PORT="${PORT:-8080}"

# Debug: show PORT and config before Apache starts
echo "[entrypoint] PORT=${PORT}"
echo "Listen ${PORT}" > /etc/apache2/ports.conf
sed -i "s/8080/${PORT}/g" /etc/apache2/sites-available/000-default.conf
echo "[entrypoint] ports.conf:"
cat /etc/apache2/ports.conf
echo "[entrypoint] 000-default.conf (first 5 lines):"
head -5 /etc/apache2/sites-available/000-default.conf
echo "[entrypoint] apache2ctl configtest:"
/usr/sbin/apache2ctl configtest || true

exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
