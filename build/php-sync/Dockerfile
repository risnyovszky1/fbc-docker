FROM php:8.3-fpm

ENV ORACLE_HOME=/opt/oracle/instantclient
ENV LD_LIBRARY_PATH=$LD_LIBRARY_PATH:$ORACLE_HOME
ENV PATH=$ORACLE_HOME:$PATH

RUN apt-get update && \
    apt-get install -y libxml2-dev libpng-dev libzip-dev unzip libaio1 libaio-dev

COPY build-assets/* \
     /tmp/

COPY build-assets-2/* \
     /tmp2/

#RUN #mkdir -p /opt/oracle && \
#    unzip /tmp/instantclient-basic-linux.arm64-19.26.0.0.0dbru.zip && \
#    mv instantclient_19_26 /opt/oracle/instantclient/ && \
#    unzip /tmp/instantclient-sdk-linux.arm64-19.26.0.0.0dbru.zip  && \
#    mv instantclient_19_26/*  /opt/oracle/instantclient/ && \
#    rm -r instantclient_19_26 /tmp/instantclient*  && \
#    echo /opt/oracle/instantclient > /etc/ld.so.conf.d/oracle-instantclient.conf && \
#    ldconfig && \
#    echo "Finished setting up the Oracle SDK."

RUN mkdir -p /opt/oracle && \
    unzip /tmp/instantclient-basic-linux.arm64-19.26.0.0.0dbru.zip && \
    mv instantclient_19_26 /opt/oracle/instantclient/ && \
    mv /tmp2/*  /opt/oracle/instantclient/ && \
    echo /opt/oracle/instantclient > /etc/ld.so.conf.d/oracle-instantclient.conf && \
    ldconfig && \
    echo "Finished setting up the Oracle SDK."

RUN docker-php-ext-install pdo pdo_mysql soap zip intl

# Install OCI8 extension
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient \
    && docker-php-ext-install oci8

# Install PDO_OCI extension
RUN docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient \
    && docker-php-ext-install pdo_oci

# Allow Composer in the container
ARG COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ALLOW_SUPERUSER=${COMPOSER_ALLOW_SUPERUSER}

ARG COMPOSER_AUTH='{"github-oauth":{"github.com":"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"}}'
ENV COMPOSER_AUTH=${COMPOSER_AUTH}

COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Ensure PHP-FPM listens on all interfaces
RUN sed -i "s/listen = \/run\/php\/php8.3-fpm.sock/listen = 9000/" /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm"]
