#!/bin/bash
set -e

# Use Railway's PORT or default to 8080
PORT="${PORT:-8080}"

# Apache: listen on dynamic port
echo "Listen ${PORT}" > /etc/apache2/ports.conf
sed -i "s/8080/${PORT}/g" /etc/apache2/sites-available/000-default.conf

exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
