FROM php:5.4.44-fpm

# PHP Configuration
RUN set -x \
	&& apt-get update \
    && apt-get install software-properties-common -y \
    && add-apt-repository non-free -y \
    && apt-get update \
	&& apt-get upgrade -y

RUN apt-get install -y \
    libbz2-dev \
    zlib1g-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libicu-dev \
    libmcrypt-dev \
    libxml2-dev \
    libxslt-dev

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install bz2
RUN docker-php-ext-install zip
RUN docker-php-ext-install calendar
RUN docker-php-ext-install dba
RUN docker-php-ext-install exif
RUN docker-php-ext-configure gd --with-freetype-dir=/usr --with-jpeg-dir=/usr
RUN docker-php-ext-install gd
RUN docker-php-ext-install gettext
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install mcrypt
RUN docker-php-ext-install mysql mysqli pdo pdo_mysql
RUN docker-php-ext-install soap
RUN docker-php-ext-install xmlrpc
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install xsl
RUN yes '' | pecl install -f apc
RUN docker-php-ext-configure hash --with-mhash

#USER www-data
CMD ["php-fpm"]

