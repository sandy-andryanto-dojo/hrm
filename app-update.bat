@echo off
composer update && composer dump-autoload && npm update && npm install && npm audit fix --force