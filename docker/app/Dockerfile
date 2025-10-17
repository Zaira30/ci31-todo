FROM php:7.4-apache

# Instala extensões e habilita mod_rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

# Define ServerName para evitar warning e aplica DocumentRoot correto
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Substitui o VirtualHost padrão
RUN echo '<VirtualHost *:80>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Permissões (útil em dev)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
