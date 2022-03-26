test:
	docker exec -it php_assignment ./vendor/bin/phpunit

rebuild:
	docker-compose up --build -d