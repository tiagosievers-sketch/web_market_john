#!/bin/bash

# Diretório de logs do Laravel
LOG_DIR="/var/www/html/storage/logs"

# Formato do nome do arquivo
LOG_FILE="$LOG_DIR/laravel-$(date +\%Y-\%m-\%d).log"

# Criar o arquivo de log
touch "$LOG_FILE"

# Definir permissões para 0777
chmod 0777 "$LOG_FILE"

# Definir o dono do arquivo para www-data
chown www-data:www-data "$LOG_FILE"
