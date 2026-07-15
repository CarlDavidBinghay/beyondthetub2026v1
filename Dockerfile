FROM php:8.2-apache

RUN apt-get update \
  && apt-get install -y --no-install-recommends git unzip libzip-dev \
  && docker-php-ext-install zip \
  && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
  && find /var/www/html/storage -type d -exec chmod 775 {} + \
  && find /var/www/html/storage -type f -exec chmod 664 {} +

EXPOSE 80

CMD ["apache2-foreground"]
