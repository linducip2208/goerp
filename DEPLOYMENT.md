# GoERP — Deployment Guide

## Requirements

| Software | Version |
|----------|---------|
| PHP | 8.2+ |
| MySQL | 8.0+ |
| Composer | 2.x |
| Node.js | 18+ |
| Web Server | Nginx or Apache |

---

## Step 1: Clone & Install

```bash
git clone https://github.com/linducip2208/goerp.git
cd goerp
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

## Step 2: Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_NAME="GoERP"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=goerp
DB_USERNAME=root
DB_PASSWORD=your-password

LICENSE_SERVER_URL=https://whitelabel.co.id
LICENSE_DEV_BYPASS=false
```

## Step 3: Database

```bash
php artisan migrate
php artisan db:seed --class=DemoDataSeeder
```

## Step 4: Create Admin

```bash
php artisan make:filament-user --name="Admin" --email="admin@yourdomain.com" --password="your-password"
```

## Step 5: Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Step 6: Scheduler

Add to crontab:
```
* * * * * cd /path/to/goerp && php artisan schedule:run >> /dev/null 2>&1
```

## Step 7: Queue Worker

Supervisor config (`/etc/supervisor/conf.d/goerp-worker.conf`):
```ini
[program:goerp-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/goerp/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/goerp/storage/logs/worker.log
stopwaitsecs=3600
```

## Step 8: Nginx Config

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/goerp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Step 9: SSL (Optional)

```bash
certbot --nginx -d yourdomain.com
```

---

## Directory Structure

```
goerp/
├── app/            → Application logic
├── bootstrap/      → Framework bootstrap
├── config/         → Configuration files
├── database/       → Migrations & seeders
├── docs/           → Architecture documentation
├── public/         → Web root
│   ├── build/      → Vite compiled assets
│   ├── css/        → Filament assets
│   └── js/         → Filament JS
├── resources/      → Views, CSS, JS
│   ├── css/filament/admin/theme.css
│   └── views/
├── routes/         → Web, console, API routes
├── storage/        → Logs, cache, uploads
│   └── app/backups/ → Database backups
└── vendor/         → Composer packages
```

---

## Post-Deploy Checklist

- [ ] `.env` configured with production values
- [ ] `APP_DEBUG=false`
- [ ] Database migrated
- [ ] Admin user created
- [ ] Storage permissions set
- [ ] Scheduler cron configured
- [ ] Queue supervisor configured
- [ ] Nginx config applied
- [ ] SSL certificate installed
- [ ] `LICENSE_DEV_BYPASS=false`
- [ ] Open domain → wizard appears for license pairing

---

## Useful Commands

```bash
php artisan optimize:clear         # Clear all caches
php artisan config:cache           # Cache config
php artisan route:cache            # Cache routes
php artisan view:cache             # Cache views
php artisan migrate:fresh --seed   # Reset DB and seed
php artisan backup:database        # Manual database backup
php artisan seo:indexnow           # Submit URLs to IndexNow
```

## Google Search Console

1. Go to https://search.google.com/search-console
2. Add property: `https://yourdomain.com`
3. Submit sitemap: `/sitemap.xml`
4. Verify IndexNow key at `public/indexnow-key.txt`
