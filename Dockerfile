# Для начала указываем исходный образ, он будет использован как основа
FROM php:8.0.3-fpm-buster

ENV ACCEPT_EULA=Y

# устанавливаем дополнительный софт
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && apt-get update && apt-get install -y nodejs \
&& npm install -g yarn && npm config set cache /var/www/html/.npm --global \
&& apt-get update && apt-get install -y \
    libpq-dev libfreetype6-dev libjpeg62-turbo-dev zlib1g-dev libzip-dev libtidy-dev libonig-dev libicu-dev locales \
    libaio1 g++ wget rsync git zip unzip libpng-dev libxrender1 \
    libfontconfig1 fontconfig libfontconfig1-dev apt-transport-https \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/10/prod.list \
    > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && apt-get -y --no-install-recommends install \
        unixodbc-dev \
        msodbcsql17 \
    && docker-php-ext-configure intl \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    # && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype=/usr/ --with-jpeg=/usr/ \
    && docker-php-ext-install -j$(nproc) mbstring zip pdo_mysql mysqli gd exif opcache \
    && apt-get clean && rm -rf /var/cache/apk/* && docker-php-source delete

#Java Oracle Driver
RUN mkdir /opt/oracle \
    && cd /opt/oracle \
    && wget http://wtolk.ru/demo/oracle/instantclient-basic-linux.x64.zip \
    && wget http://wtolk.ru/demo/oracle/instantclient-sdk-linux.x64.zip \
    && wget http://wtolk.ru/demo/oracle/instantclient-sqlplus-linux.x64.zip \
    && unzip /opt/oracle/instantclient-basic-linux.x64.zip -d /opt/oracle \
    && unzip /opt/oracle/instantclient-sdk-linux.x64.zip -d /opt/oracle \
    && rm -rf /opt/oracle/*.zip \
    && docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient_21_1 \
    && docker-php-ext-install oci8 \
    && echo /opt/oracle/instantclient_21_1/ > /etc/ld.so.conf.d/oracle-insantclient.conf \
    && ldconfig

# Set the locale
RUN locale-gen ru_RU.UTF-8
ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8

# PHP TOOLS
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && wget http://robo.li/robo.phar \
&& chmod +x robo.phar && mv robo.phar /usr/bin/robo && curl -LO https://deployer.org/deployer.phar \
&& mv deployer.phar /usr/local/bin/dep && chmod +x /usr/local/bin/dep

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
