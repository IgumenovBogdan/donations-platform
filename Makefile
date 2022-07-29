docker-up:
	docker-compose up -d
	docker-compose exec php-fpm php artisan queue:work

docker-down:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm php-cli composer install

composer-update:
	docker-compose run --rm php-cli composer update