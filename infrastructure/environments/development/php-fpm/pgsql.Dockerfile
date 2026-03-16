FROM phpdockerio/php:8.2-fpm
WORKDIR "/application"

RUN apt-get update

RUN apt-get -y --no-install-recommends install \
        software-properties-common \
        build-essential \
        libaio1 \
        wget \
        curl \
        php8.2-dev \
        php-pear \
        php8.2-gd \
        php8.2-imap \
        php8.2-intl \
        php8.2-ldap \
        php8.2-memcached \
        php8.2-pcov \
        php8.2-soap \
        php8.2-pgsql \
        php8.2-xdebug; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/application"
