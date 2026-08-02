FROM webdevops/php-nginx:8.3
ENV WEB_DOCUMENT_ROOT=/app/public
COPY . /app
WORKDIR /app
RUN composer install --no-dev --optimize-autoloader
RUN chown -R application:application /app/storage /app/bootstrap/cache
