FROM php:7.4-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN apt-get update

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer install ; wait-for-it payroll-db:5432 -- bin/console doctrine:migrations:migrate ; php-fpm

EXPOSE 9000
