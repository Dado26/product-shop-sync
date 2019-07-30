# Change to the project directory
cd /var/www/product-sync

# Turn on maintenance mode
php artisan down

# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
printf "Pulling changes from master branch -----------------------------------------------\n"
git pull origin master

# Install/update composer dependecies
printf "Composer install -----------------------------------------------------------------\n"
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
printf "Running migrations----------------------------------------------------------------\n"
php artisan migrate --force

printf "Clearing caches ------------------------------------------------------------------\n"
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
printf "Restarting queues ----------------------------------------------------------------\n"
php artisan queue:restart

# Restart Horizon
printf "Terminating horizon --------------------------------------------------------------\n"
php artisan horizon:terminate

# Install npm dependencies
printf "Installing npm dependencies ------------------------------------------------------\n"
npm install

# Build assets using Laravel Mix
printf "Building production assets -------------------------------------------------------\n"
npm run production

# Turn off maintenance mode
php artisan up

printf "Deploy has finished successfully -------------------------------------------------\n"
