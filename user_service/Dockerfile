FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create working directory
WORKDIR /var/www

# Copy package.json and composer.json first to leverage Docker cache
COPY package.json package-lock.json /var/www/
COPY composer.json composer.lock /var/www/

# Install Node dependencies
RUN npm install

# Install PHP dependencies (no-dev for production)
# For development, you might want to remove --no-dev
RUN composer install --no-interaction --no-scripts

# Copy application files
COPY . /var/www/

# Build assets (for production)
# For development, this might not be necessary as Vite will handle it
# RUN npm run build

# Expose ports
# 8000 for PHP server, 5173 for Vite
EXPOSE 8000
EXPOSE 5173

CMD ["sh", "-c", "npm run dev"]