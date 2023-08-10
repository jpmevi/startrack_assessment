# Setting Up Laravel API on Ubuntu

This guide will assist you in setting up a Laravel API on an Ubuntu system using PHP 8.0.

## **Prerequisites**
- An Ubuntu system
- Basic understanding of terminal commands

## **Installation Steps**

### 1. **Update Your System**
Firstly, always make sure your system is updated to the latest packages.
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. **Install PHP 8.0 & Required Extensions**
To install PHP 8.0 and its required extensions, run:
```bash
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.0 php8.0-cli php8.0-fpm php8.0-json php8.0-common php8.0-mysql php8.0-zip php8.0-gd php8.0-mbstring php8.0-curl php8.0-xml php8.0-bcmath php8.0-json php8.0-sqlite3
```

### 3. **Install Composer**
Composer is the PHP dependency manager used by Laravel.
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 4. **Install SQLITE**
```bash
sudo apt-get install sqlite3
sqlite3 --version
```

### 5. **Setup Environment for Your Project**
Clone project repository:
```bash
git clone https://github.com/jpmevi/startrack_assessment/
```
Go to your project directory:
```bash
cd startrack_assessment
```
Duplicate the `.env.example` file and rename it to `.env`:
```bash
cp .env.example .env
```
Paste this inside your .env:
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:tEEkEPXw7o9juPHSe86wZDWYeu8Uc3e63+G/u/UmzIA=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite

CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
STACK_EXCHANGE_HOST="https://api.stackexchange.com/2.3/"
```

### 7. **Install and Update dependencies**
To update and install the dependencies:
```bash
composer update
```

### 7. **Run the Development Server**
To start the local development server:
```bash
php artisan serve
```
Upon successful execution, you should see a message indicating the URL to access, typically `http://127.0.0.1:8000`.

---

You're all set! You've successfully configured your Ubuntu system to run a Laravel API using PHP 8.0. Navigate to the provided URL to access your API, and use the [official Laravel documentation](https://laravel.com/docs) for further development insights.

---

If you wish to view the API documentation, please visit: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation).

---
