FROM php:8.3-apache

ARG TIMEZONE="Europe/Paris"
ENV ACCEPT_EULA=Y
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    zip \
    wget \
    ssh \
    libssl-dev \
    libffi-dev \
    ca-certificates \
    nano

# Apache SSL
RUN a2enmod ssl rewrite headers
RUN a2ensite default-ssl

# Mettre à jour les paquets et installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    gnupg \
    gnupg2 \
    unixodbc-dev \
    freetds-dev \
    && docker-php-ext-install intl pdo pdo_mysql

# Activer l'extension intl
RUN docker-php-ext-enable intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/orisha_socialcare

# Expose port 80 443
EXPOSE 80 443

# Start Apache
CMD ["apache2-foreground"]