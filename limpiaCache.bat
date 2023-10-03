cd \
cd xampp
cd htdocs
cd mtf
	rem git pull origin mtfbase
	php artisan cache:clear
	php artisan config:clear
	php artisan config:cache
pause
	