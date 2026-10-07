FROM php:8.3-cli

# ─── System dependencies ───────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        bcmath \
        pcntl \
        zip \
        exif \
        gd \
    && rm -rf /var/lib/apt/lists/*

# ─── Composer ─────────────────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ─── Working directory ────────────────────────────────────────────────────────
WORKDIR /var/www

# ─── Copy application source ─────────────────────────────────────────────────
COPY . .

# ─── PHP dependencies ────────────────────────────────────────────────────────
RUN composer config -g process-timeout 600 \
    && composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --prefer-dist

# ─── Storage & cache permissions ─────────────────────────────────────────────
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ─── Entrypoint script ───────────────────────────────────────────────────────
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
