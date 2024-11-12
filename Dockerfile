# Usa a imagem oficial do PHP com FPM para Laravel
FROM php:8.1-fpm

# Instala dependências do sistema necessárias para o Laravel e PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Instala o Composer diretamente na imagem
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos de configuração do Nginx antes para otimizar cache
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

# Copia os arquivos da aplicação para o contêiner
COPY . .

# Configura permissões para o Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instala as dependências do Laravel
RUN composer install --optimize-autoloader --no-dev

# Configura variáveis do ambiente para o Laravel
ENV APP_ENV=production
ENV DB_CONNECTION=mysql
ENV DB_HOST=mysql_db
ENV DB_PORT=3306
ENV DB_DATABASE=fitnessfoods
ENV DB_USERNAME=root
ENV DB_PASSWORD=root

# Expõe a porta para o Nginx
EXPOSE 80

# Comando para iniciar o PHP-FPM e Nginx
CMD service nginx start && php-fpm
