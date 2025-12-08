FROM php:8.0-apache

# Usar Argentina como zona horaria
ENV TZ=America/Argentina/Buenos_Aires
ENV LANG=es_AR.UTF-8
ENV LANGUAGE=es_AR.UTF-8
ENV LC_ALL=es_AR.UTF-8

# Instalar tzdata (si es necesario)
RUN apt-get update && apt-get install -y \
zip unzip curl libpq-dev libonig-dev libxml2-dev \
&& docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install intl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

RUN apt-get install lynx iputils-ping -y
RUN apt install locales -y

RUN pecl install pcov \
    && docker-php-ext-enable pcov

RUN apt update --fix-missing
RUN apt install git -y

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs cron

RUN service cron start

WORKDIR /var/www/html
