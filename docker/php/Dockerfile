FROM php:8.3.4-fpm-alpine3.19

RUN apk update && apk upgrade
RUN apk add curl-dev

# install pdo
RUN docker-php-ext-install pdo \
    pdo_mysql

RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
