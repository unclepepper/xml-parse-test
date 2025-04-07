FROM unit:php8.4

ARG UID
ARG GID

RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# Устанавливаем необходимые пакеты для PostgreSQL
RUN apt-get update && apt-get install -y \
    unzip \
    nano \
    git \
    zip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    pdo_mysql \
    && apt-get clean



COPY unit-config.json /docker-entrypoint.d/config.json
COPY unit-config.json /etc/unit/unit.json


WORKDIR /var/www/app


COPY . .


CMD ["unitd",  "--no-daemon", "--control", "unix:/var/run/unit/control.sock"]

