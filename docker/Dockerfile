FROM composer:2.0.8 as composer
FROM php:7.2-fpm

RUN CPU_CORES="$(getconf _NPROCESSORS_ONLN)"
ENV MAKEFLAGS="-j${CPU_CORES}"

RUN apt update -y && apt install -y \
    wget \
    zip \
    git \
    apt-utils \
    sudo \
    libgmp-dev \
    libzip-dev && \
    pecl install psr && \
    pecl install phalcon

RUN docker-php-ext-install zip && \
    docker-php-ext-enable psr phalcon

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

CMD ["php-fpm"]
