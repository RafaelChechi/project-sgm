#COMPOSER
FROM composer as builder
WORKDIR /app/
COPY ./src ./

RUN composer install --optimize-autoloader --no-dev
RUN composer dump-autoload -o

#SERVER
FROM chechidev/nginx-php7.4:v1

COPY --from=builder /app .
RUN chmod -R 777 storage/

#PHP
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan config:cache
RUN php artisan config:clear
RUN php artisan l5-swagger:generate

EXPOSE 80