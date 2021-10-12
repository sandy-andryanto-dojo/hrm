@echo off
php artisan optimize && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache && php artisan config:cache &&php artisan route:list