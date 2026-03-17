FROM php:8.2.1-apache-bullseye

ARG DEBIAN_FRONTEND=noninteractive
ENV CONTEXT=infrastructure/environments/production

RUN apt-get update && apt-get install -y \
    software-properties-common \
    build-essential \
    libaio1 \
    wget \
    curl \
    libmemcached-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    memcached \
    libmemcached-tools \
    libxml2-dev \
    unzip \
    zip \
    libldap2-dev \
    supervisor \
    cron \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Diretórios do supervisor e logs
RUN mkdir -p /etc/supervisor/conf.d /var/log/supervisor

# Composer
COPY --from=composer:2.2.0 /usr/bin/composer /usr/local/bin/composer

# Extensões PHP
RUN docker-php-ext-install gettext intl pdo_mysql

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis && docker-php-ext-enable redis

# Apache (port set at runtime via entrypoint from $PORT)
COPY ${CONTEXT}/apache/default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod headers rewrite log_forensic
RUN echo "ForensicLog /var/log/apache2/access.log" >> /etc/apache2/apache2.conf

# App Laravel
COPY . /var/www/html/

WORKDIR /var/www/html

# Ajuste de permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage

# Logs
RUN touch /var/log/cron.log \
    && chown www-data:www-data /var/log/cron.log

# Supervisor
COPY ${CONTEXT}/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Cron apenas para scheduler
COPY ./infrastructure/cron/crontab /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler && crontab /etc/cron.d/laravel-scheduler

# Entrypoint: set Apache to listen on $PORT (Railway)
COPY infrastructure/scripts/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]