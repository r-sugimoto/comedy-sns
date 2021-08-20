#イメージのベースを指定
FROM php:7.4-fpm

#php.ini カスタマイズ
COPY php.ini /usr/local/etc/php/

#composerのインストール
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

#npmのインストール
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

#パッケージ管理ツールapt-getの更新と必要パッケージのインストール
RUN apt-get update \
    && apt-get install -y wget git zip libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    unzip \
    && docker-php-ext-install pdo_mysql bcmath\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd
#コンテナ内に入った時のディレクトリを指定
WORKDIR /var/www/html