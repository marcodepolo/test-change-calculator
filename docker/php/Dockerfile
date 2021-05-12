FROM php:7.4-fpm-alpine

RUN apk add --update --no-cache unzip curl git wget make jq bash bash-completion openssl grep nano yarn \
    && wget -q -O /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
        || (echo "Failed while downloading php extension installer!"; exit 1) \
    && chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
        xdebug

WORKDIR /var/www/html

RUN set -xe; \
    curl -sl https://getcomposer.org/composer-stable.phar -o /usr/local/bin/composer; \
    chmod +x /usr/local/bin/composer;

ARG XDEBUG_REMOTE_HOST=172.17.0.1
ARG XDEBUG_REMOTE_PORT=9000

# xdebug settings
RUN set -xe; \
    echo "xdebug.remote_enable=On" >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.remote_autostart=On" >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.remote_connect_back=On" >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.remote_host="${XDEBUG_REMOTE_HOST} >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.remote_port="${XDEBUG_REMOTE_PORT} >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.idekey=dis-docker-server" >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.mode=coverage" >> ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini;

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# php-fpm config
ENV PHP_FPM_PM_LOG_LEVEL=${debug}

ARG DOCKER_UID

RUN set -xe; \
    apk add --no-cache --virtual .build-deps shadow; \
    mkdir -p /var/www/html; \
    usermod -u ${DOCKER_UID} www-data -d /var/www; \
    chown -R www-data:www-data /var/www; \
    apk del --no-network .build-deps;
