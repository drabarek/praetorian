FROM php:7.4-fpm
RUN apt-get update \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev zlib1g-dev libicu-dev g++ libxml2-dev \
     git zip
RUN docker-php-ext-install opcache \
    && docker-php-ext-install pdo_mysql && docker-php-ext-install mysqli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY overrides.conf /etc/php/7.4/fpm/pool.d/z-overrides.conf
ADD php-ini-overrides.ini /etc/php/7.4/fpm/conf.d/99-overrides.ini
COPY entrypoint.sh /etc/entrypoint.sh

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]
