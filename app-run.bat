@echo off
SET /a _rand=(%RANDOM%*500/32768)+10
ECHO php artisan optimize && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache && php artisan route:list && php artisan serve --port=%_rand%