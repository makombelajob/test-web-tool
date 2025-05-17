FROM php:8.2-apache

# Met à jour les paquets et installe les dépendances de base
RUN apt-get update && apt-get install -y \
    apt-utils \
    gnupg \
    ca-certificates \
    lsb-release \
    curl \
    wget \
    unzip \
    iputils-ping \
    dnsutils \
    net-tools \
    traceroute

# Installer les outils nécessaires un par un
RUN apt-get install -y \
    nmap \
    whois \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier les fichiers du projet
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
