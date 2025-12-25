FROM php:8.2-apache

# 1. Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \    # <--- NUEVA DEPENDENCIA
    zip \
    unzip \
    curl \
    git

# Instalar extensiones de PHP incluyendo las de PostgreSQL
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd  # <--- pdo_pgsql AÑADIDO

# 2. Instalar Node.js (necesario para compilar estilos con Vite o Mix)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 3. Configurar Apache para apuntar a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# 4. Copiar los archivos del proyecto al contenedor
COPY . /var/www/html
WORKDIR /var/www/html

# 5. Instalar Composer y las dependencias de PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# 6. Instalar dependencias de JS y compilar estilos (CSS/JS)
# Esto solucionará el problema de los estilos faltantes
RUN npm install
RUN npm run build

# 7. Crear estructura de carpetas de storage y logs
RUN mkdir -p /var/www/html/storage/framework/cache/data \
             /var/www/html/storage/framework/app \
             /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/logs

# 8. Corregir permisos de carpetas (para evitar el Error 500 de permisos)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
