FROM php:7.3-apache 

ENV TERM=xterm

# SYSTEM SETUP
RUN apt-get update -y
RUN apt-get install -y --no-install-recommends apt-utils \
    && apt-get install -y sendmail \
    && apt-get install -y libpng-dev \
    && apt-get install -y libjpeg62-turbo-dev \    
    && apt-get install -y libfreetype6-dev \    
    && apt-get install -y libxml2-dev \    
    && apt-get install -y libssl-dev \    
    && apt-get install -y libzip-dev \
    && apt-get install -y libmcrypt-dev \    
    && apt-get install -y zlib1g-dev 

# APACHE SETUP
RUN a2enmod rewrite
RUN service apache2 restart

# PHP EXTENSIONS
RUN docker-php-ext-install mysqli 
RUN docker-php-ext-install zip
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
