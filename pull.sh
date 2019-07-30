# Change to the project directory
cd /var/www/product-sync

# Turn on maintenance mode
php artisan down

# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
printf "\nPulling changes from master branch -----------------------------------------------\n"
git pull origin master

# Install/update composer dependecies
printf "\nComposer install -----------------------------------------------------------------\n"
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
printf "\nRunning migrations----------------------------------------------------------------\n"
php artisan migrate --force

printf "\nClearing caches ------------------------------------------------------------------\n"
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
printf "\nRestarting queues ----------------------------------------------------------------\n"
php artisan queue:restart

# Restart Horizon
printf "\nTerminating horizon --------------------------------------------------------------\n"
php artisan horizon:terminate

# Install npm dependencies
printf "\nInstalling npm dependencies ------------------------------------------------------\n"
npm install

# Build assets using Laravel Mix
printf "\nBuilding production assets -------------------------------------------------------\n"
npm run production

# Turn off maintenance mode
php artisan up

printf "\nDeploy has finished successfully -------------------------------------------------\n"
