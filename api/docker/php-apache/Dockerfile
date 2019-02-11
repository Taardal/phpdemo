FROM php:7.2-apache
RUN docker-php-ext-install mysqli
COPY apache.conf /usr/local/apache2/conf/apache.conf
RUN echo "Include /usr/local/apache2/conf/apache.conf" >> /usr/local/apache2/conf/httpd.conf