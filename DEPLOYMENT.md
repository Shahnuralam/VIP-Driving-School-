# VIP Driving School Hobart - Production Deployment Checklist

## Pre-Deployment Requirements

### 1. Server Requirements
- [ ] PHP 8.2 or higher installed
- [ ] MySQL/MariaDB database server
- [ ] Composer installed
- [ ] Node.js and npm installed
- [ ] Apache/Nginx web server with mod_rewrite enabled
- [ ] SSL certificate installed (HTTPS)

### 2. Environment Configuration
- [ ] Copy `.env.production` to `.env` on production server
- [ ] Update `APP_URL` with your actual domain (e.g., https://vipdrivingschoolhobart.com.au)
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false` (CRITICAL for security)
- [ ] Generate new `APP_KEY` if needed: `php artisan key:generate`

### 3. Database Setup
- [ ] Create production database
- [ ] Update database credentials in `.env`:
  - `DB_HOST` (your hosting provider's database host)
  - `DB_DATABASE` (database name)
  - `DB_USERNAME` (database username)
  - `DB_PASSWORD` (database password)
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed database if needed: `php artisan db:seed --force`

### 4. Mail Configuration
- [ ] Configure SMTP settings for production email service
- [ ] Test email sending functionality
- [ ] Common providers:
  - Gmail: smtp.gmail.com:587 (TLS)
  - SendGrid: smtp.sendgrid.net:587
  - Mailgun: smtp.mailgun.org:587

### 5. Payment Gateway (Stripe)
- [ ] Replace test keys with LIVE Stripe keys
- [ ] `STRIPE_KEY=pk_live_...`
- [ ] `STRIPE_SECRET=sk_live_...`
- [ ] `STRIPE_WEBHOOK_SECRET=whsec_...`
- [ ] Configure Stripe webhooks to point to your production URL

### 6. File Permissions
Set correct permissions on production server:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 7. Build Assets
```bash
npm install --production
npm run build
```

### 8. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 9. Web Server Configuration

#### Option A: Document Root Points to Laravel Root
If your hosting provider's document root points to the Laravel root directory (not the `public` folder), the existing `.htaccess` file will handle routing.

**Current Setup:** ✅ Already configured in root `.htaccess`

#### Option B: Document Root Points to Public Folder (RECOMMENDED)
If possible, configure your web server's document root to point to:
```
/path/to/vipdrivingschoolhobart/backend/public
```

This is more secure and is Laravel's recommended setup.

### 10. Security Checklist
- [ ] `APP_DEBUG=false` in production
- [ ] `.env` file is NOT accessible via web (should be outside public folder)
- [ ] Storage and cache directories have correct permissions
- [ ] SSL certificate is installed and working
- [ ] All sensitive credentials are updated for production
- [ ] Remove or secure any development/debug routes

### 11. Testing on Production
- [ ] Test homepage loads correctly
- [ ] Test user registration/login
- [ ] Test booking functionality
- [ ] Test payment processing with Stripe
- [ ] Test email notifications
- [ ] Check all routes work correctly
- [ ] Test on mobile devices

### 12. Monitoring & Maintenance
- [ ] Set up error logging and monitoring
- [ ] Configure automated backups for database
- [ ] Set up SSL certificate auto-renewal
- [ ] Monitor application logs: `storage/logs/laravel.log`

## Common Deployment Issues

### Issue: "500 Internal Server Error"
**Solutions:**
1. Check `storage/logs/laravel.log` for errors
2. Verify file permissions on `storage` and `bootstrap/cache`
3. Run `php artisan config:clear`
4. Check `.env` file exists and has correct values

### Issue: "No application encryption key has been specified"
**Solution:**
```bash
php artisan key:generate
```

### Issue: Assets (CSS/JS) not loading
**Solutions:**
1. Run `npm run build`
2. Clear browser cache
3. Check `.htaccess` is working (mod_rewrite enabled)
4. Verify `APP_URL` in `.env` matches your domain

### Issue: Database connection failed
**Solutions:**
1. Verify database credentials in `.env`
2. Check database server is accessible from web server
3. Ensure database user has correct permissions
4. Test connection: `php artisan migrate:status`

## Quick Deployment Commands

```bash
# On production server, in the backend directory:

# 1. Install dependencies
composer install --optimize-autoloader --no-dev

# 2. Install and build frontend assets
npm install --production
npm run build

# 3. Run migrations
php artisan migrate --force

# 4. Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 5. Set permissions
chmod -R 755 storage bootstrap/cache
```

## Rollback Plan

If something goes wrong:
1. Keep a backup of your database before migration
2. Keep a backup of your `.env` file
3. To rollback database: `php artisan migrate:rollback`
4. To clear all caches: `php artisan optimize:clear`

## Support Resources

- Laravel Deployment Docs: https://laravel.com/docs/12.x/deployment
- Laravel Forge (managed hosting): https://forge.laravel.com
- Stripe Live Mode: https://stripe.com/docs/keys#test-live-modes
