first-build:
	docker-compose -f docker-compose-dev.yml up -d --build
	npm install
	npm run build
	docker exec 2easy-ede-web-backend composer install
build:
	docker-compose -f docker-compose-dev.yml up -d --build
	npm run build
stop:
	docker-compose stop
up:
	docker-compose -f docker-compose-dev.yml up -d
down:
	docker-compose -f docker-compose-dev.yml down
laravel-install:
	docker exec 2easy-ede-web-backend composer install
laravel-migrate:
	docker exec 2easy-ede-web-backend php artisan migrate
laravel-seed:
	docker exec 2easy-ede-web-backend php artisan migrate:refresh --seed
laravel-config:
	docker exec 2easy-ede-web-backend php artisan config:clear
	docker exec 2easy-ede-web-backend php artisan config:cache
laravel-config-clear:
	docker exec 2easy-ede-web-backend php artisan config:clear
laravel-config-cache:
	docker exec 2easy-ede-web-backend php artisan config:cache
laravel-route:
	docker exec 2easy-ede-web-backend php artisan route:clear
	docker exec 2easy-ede-web-backend php artisan route:cache
laravel-route-clear:
	docker exec 2easy-ede-web-backend php artisan route:clear
laravel-route-cache:
	docker exec 2easy-ede-web-backend php artisan route:cache
laravel-application-seed:
	docker exec 2easy-ede-web-backend php artisan db:seed --class=ApplicationSeeder
laravel-optimize:
	docker exec 2easy-ede-web-backend php artisan optimize:clear
laravel-test:
	docker exec 2easy-ede-web-backend php artisan test --filter ApplicationFluxTest
laravel-test-all:
	docker exec 2easy-ede-web-backend php artisan test
laravel-run-test:
	docker exec 2easy-ede-web-backend php artisan migrate:refresh --seed
	docker exec 2easy-ede-web-backend php artisan test --filter ApplicationFluxTest
laravel-queue:
	docker exec 2easy-ede-web-backend php artisan queue:work
prod-build:
	docker compose up -d --build
prod-stop:
	docker compose stop
prod-up:
	docker compose up -d
prod-down:
	docker compose down
prod-down-v:
	docker compose down -v
prod-first-build:
	docker compose up -d --build
	docker exec 2easy-ede-web-backend composer install
	docker exec 2easy-ede-web-backend npm install
	docker exec 2easy-ede-web-backend npm run build
prod-terminal:
	docker exec -it 2easy-ede-web-backend bash
supervisor-start:
	supervisorctl start 2easyedebackend-worker
supervisor-restart:
	supervisorctl restart 2easyedebackend-worker
supervisor-stop:
	supervisorctl stop 2easyedebackend-worker