FROM php:8.3-apache 
RUN docker-php-ext-install pdo pdo_mysql
# Instala dependências necessárias para o GD
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && rm -rf /var/lib/apt/lists/*

# Ativa mod_rewrite do Apache
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY ./src /var/www/html
