FROM php:8.1-fpm

ARG INSTALL_NODE=true

RUN if [ ${INSTALL_NODE} = true ]; then \
    curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get update && apt-get install -y nodejs && apt-get clean && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y yarn && \
    yarn global add pm2 && pm2 install pm2-logrotate \
    ;fi

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
      gnupg2 \
      git \
      libzip-dev \
      zip \
      unzip \
      jpegoptim optipng pngquant gifsicle netcat libmagickwand-dev \
      imagemagick zlib1g-dev libicu-dev g++ libpq-dev\
    && pecl install apcu \
    && pecl install imagick \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip bcmath opcache pdo pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql imagick sodium \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ARG user=admin
ARG group=admin
ARG uid=1000
ARG gid=1000

RUN groupadd -g ${gid} ${group}
RUN useradd -u ${uid} -ms /bin/bash -g ${group} ${user}

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=${group}:${user} . /var/www

# Change current user to www
USER ${user}

EXPOSE 9000