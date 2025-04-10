FROM php:8.3-fpm-alpine

# Install necessary PHP extensions (you might need to add more)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy your application files into the container
COPY . /var/www/html/

# Set file permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 775 /var/www/html/

# Expose the PHP-FPM port
EXPOSE 9000

# Command to start PHP-FPM
CMD ["php-fpm"]
