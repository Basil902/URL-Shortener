FROM php:8.2-fpm 

# Create working directory
WORKDIR /var/www/html

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get update && apt-get install -y \
    nodejs \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy package.json and composer.json first to leverage Docker (in the current dir mentioned under WORKDIR)
COPY package*.json composer.json composer.lock ./

# Install Node dependencies
ENV NODE_ENV=development
RUN npm install

# Install PHP dependencies
# For development, you might want to remove --no-dev
RUN composer install --no-interaction --no-scripts

# Copy application files into /var/www
COPY . .

# Build assets (for production)
RUN npm run build

# Fix permissions again (in case COPY overrides them)
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# 9000 for php fpm
EXPOSE 9000

CMD ["php-fpm", "-F", "-R"]