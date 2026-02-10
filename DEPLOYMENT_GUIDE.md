# Deployment Guide: OSSAGA Valentine

This guide assumes you have a **Linux VPS (Ubuntu 22.04 or 24.04)** and a **Domain Name** pointed to your server's IP address.

## 1. Server Provisioning

Connect to your server via SSH:

```bash
ssh root@your_server_ip
```

Run these commands to install the necessary software (Nginx, PHP 8.4, PostgreSQL, Composer):

```bash
# Update System
apt update && apt upgrade -y

# Install Core Dependencies
apt install -y software-properties-common curl zip unzip git

# Add PHP Repository (if on Ubuntu)
add-apt-repository ppa:ondrej/php -y
apt update

# Install Nginx, PHP 8.4, and PostgreSQL
apt install -y nginx postgresql postgresql-contrib php8.4 php8.4-fpm php8.4-pgsql php8.4-mbstring php8.4-xml php8.4-curl
```

## 2. Database Setup

Create the database and user for production:

```bash
# Switch to postgres user
sudo -u postgres psql

# Run SQL commands
CREATE DATABASE ossaga_valentine;
CREATE USER ossaga_user WITH PASSWORD 'STRONG_PASSWORD_HERE';
GRANT ALL PRIVILEGES ON DATABASE ossaga_valentine TO ossaga_user;
\q
```

## 3. Application Deployment

We will deploy the code to `/var/www/ossaga_valentine`.

```bash
# Create directory
mkdir -p /var/www/ossaga_valentine
cd /var/www/ossaga_valentine

# Clone your repository (Recommended)
# git clone https://github.com/yourusername/your-repo.git .
# OR Copy files manually if not using Git yet.

# Install PHP Dependencies
composer install --no-dev --optimize-autoloader

# Set Permissions
chown -R www-data:www-data /var/www/ossaga_valentine
chmod -R 775 storage bootstrap/cache
```

## 4. Configuration

Create the production `.env` file:

```bash
cp .env.example .env
nano .env
```

Update these values in `.env`:

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ossaga_valentine
DB_USERNAME=ossaga_user
DB_PASSWORD=STRONG_PASSWORD_HERE
```

Generate the key and cache config:

```bash
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## 5. Web Server Setup (Nginx)

I have provided a configuration file `ossaga_valentine.nginx.conf` in your project. Copy it to Nginx sites:

```bash
cp ossaga_valentine.nginx.conf /etc/nginx/sites-available/ossaga_valentine
ln -s /etc/nginx/sites-available/ossaga_valentine /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default  # Remove default site if needed
nginx -t  # Test config
systemctl restart nginx
```

## 6. SSL Certificate (HTTPS)

Secure your site with a free Let's Encrypt certificate:

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d your-domain.com
```

Your site should now be live at `https://your-domain.com`! 🚀
