FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini


COPY src/app            /var/www/src/app
COPY src/bootstrap      /var/www/src/bootstrap
COPY src/config         /var/www/src/config
COPY src/database       /var/www/src/database
COPY src/public         /var/www/src/public
COPY src/resources      /var/www/src/resources
COPY src/routes         /var/www/src/routes
COPY src/storage        /var/www/src/storage
COPY src/tests          /var/www/src/tests
COPY src/artisan        /var/www/src/artisan
COPY src/package.json   /var/www/src/package.json
COPY src/phpunit.xml    /var/www/src/phpunit.xml
#COPY webpack.mix.js /var/www/webpack.mix.js

COPY src/composer.*  ./

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
# alias
RUN echo "alias a='artisan'" >> /root/.bashrc

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

RUN composer install \
      --no-interaction \
      --no-plugins \
      --no-suggest \
      --no-scripts \
      --no-autoloader \
      --prefer-dist


RUN composer dump-autoload  --no-scripts --optimize && \
    chown -R root:www-data /var/www && \
    chmod 755 -R /var/www && \
    chmod -R 775 /var/www/src/storage && \
    chmod -R 775 /var/www/src/bootstrap/cache

WORKDIR /var/www
