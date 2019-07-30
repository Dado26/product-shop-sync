# Change to the project directory
cd /var/www/product-sync

# Turn on maintenance mode
php artisan down

# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
git pull origin master

# Install/update composer dependecies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear

# Clear expired password reset tokens
# php artisan auth:clear-resets

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Queue restart
php artisan queue:restart

# Restart Horizon
php artisan horizon:terminate

# Install node modules & build
npm ci

# Build assets using Laravel Mix
# npm run production

# Turn off maintenance mode
php artisan up
