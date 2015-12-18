FROM php:7-apache

# PHP extension
RUN requirements="zlib1g-dev libicu-dev libmcrypt-dev git" \
    && apt-get update && apt-get install -y $requirements && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && pecl install apcu-4.0.8 && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini \
    && apt-get purge --auto-remove -y

# Apache & PHP configuration
RUN a2enmod rewrite
ADD docker/apache/vhost.conf /etc/apache2/sites-enabled/default.conf
ADD docker/php/php.ini /usr/local/etc/php/php.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

# Add the application
ADD . /app
WORKDIR /app

# Remove cache and logs if some and fixes permissions
RUN chown www-data .

# Run installation with private credentials
RUN composer install -o

# Run Apache2
CMD ["/app/docker/apache/run.sh"]
