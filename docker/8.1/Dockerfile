FROM ubuntu:22.04

LABEL maintainer="Vikram Zaini"

ARG WWWGROUP=1000
ARG NODE_VERSION=20

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# Base tools
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && apt-get update \
    && apt-get install -y \
       gnupg \
       dirmngr \
       gosu \
       curl \
       ca-certificates \
       zip \
       unzip \
       git \
       supervisor \
       sqlite3 \
       libcap2-bin \
       libpng-dev \
       software-properties-common \
       python3 \
    && rm -rf /var/lib/apt/lists/*

# PHP (Ondřej Surý repo for 22.04 "jammy")
RUN add-apt-repository ppa:ondrej/php -y \
    && apt-get update \
    && apt-get install -y \
       php8.1-cli php8.1-dev \
       php8.1-pgsql php8.1-sqlite3 php8.1-gd \
       php8.1-curl \
       php8.1-imap php8.1-mysql php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
       php8.1-intl php8.1-readline \
       php8.1-ldap \
       php8.1-msgpack php8.1-igbinary php8.1-redis php8.1-swoole \
       php8.1-memcached php8.1-pcov php8.1-xdebug \
    && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/bin/ --filename=composer

# Node + Yarn (Ubuntu 22.04 safe way)
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && curl -fsSL https://dl.yarnpkg.com/debian/pubkey.gpg \
       | gpg --dearmor -o /usr/share/keyrings/yarn.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian stable main" \
       > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn \
    && rm -rf /var/lib/apt/lists/*

# DB clients
RUN apt-get update \
    && apt-get install -y mysql-client postgresql-client \
    && rm -rf /var/lib/apt/lists/*

# Capabilities
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1

# Sail user
ARG WWWGROUP=1000
RUN groupadd -g ${WWWGROUP} sail \
    && useradd -ms /bin/bash -u 1337 -g sail sail

# Copy configs
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.1/cli/conf.d/99-sail.ini

RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]
