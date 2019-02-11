FROM php:7.2-apache
RUN docker-php-ext-install mysqli

COPY httpd.conf /usr/local/apache2/conf/httpd.conf
RUN echo "Include /usr/local/apache2/conf/httpd.conf" >> /usr/local/apache2/conf/httpd.conf

# Allow .htaccess with RewriteEngine
RUN a2enmod rewrite

# Suppress warning "AH00558: apache2: Could not reliably determine the server's fully qualified domain name"
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
