test: install phpcs phpstan phpunit behat

vendor:
	docker-compose exec php bash -c 'composer install'

install: vendor
	docker-compose up -d \
    && docker-compose exec php bash -c 'bin/console about'

phpcs: vendor
	docker-compose up -d \
    && docker-compose exec php bash -c 'vendor/bin/php-cs-fixer fix --dry-run --allow-risky=yes src/'

phpstan: vendor
	docker-compose up -d \
	&& docker-compose exec php bash -c 'vendor/bin/phpstan analyse --level=7 src/'

phpunit: vendor
	docker-compose up -d \
	&& docker-compose exec php bash -c 'vendor/bin/phpunit'

behat: vendor
	docker-compose up -d \
    && docker-compose exec php bash -c 'vendor/bin/behat'

fix: vendor
	docker-compose up -d \
	&& docker-compose exec php bash -c 'vendor/bin/php-cs-fixer fix --verbose --allow-risky=yes src/'


###########
# Containers
###########

php:
	docker-compose exec php bash

nginx:
	docker-compose exec php bash

###########
# Various
###########

start:
	docker-compose up -d \
	&& docker-compose exec php bash -c 'composer install' \
	&& docker-compose exec php bash -c 'chown -R www-data:www-data var/'

stop:
	docker-compose down
