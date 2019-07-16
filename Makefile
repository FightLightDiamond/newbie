ifndef u
u:=sotatek
endif

ifndef env
env:=dev
endif

OS:=$(shell uname)

docker-start:
	cp laravel-echo-server.json.example laravel-echo-server.json
	@if [ $(OS) = "Linux" ]; then\
		sed -i -e "s/localhost:8000/web:8000/g" laravel-echo-server.json; \
		sed -i -e "s/\"redis\": {}/\"redis\": {\"host\": \"redis\"}/g" laravel-echo-server.json; \
	else\
		sed -i '' -e "s/localhost:8000/web:8000/g" laravel-echo-server.json; \
		sed -i '' -e "s/\"redis\": {}/\"redis\": {\"host\": \"redis\"}/g" laravel-echo-server.json; \
	fi
	docker-compose up -d

docker-restart:
	docker-compose down
	make docker-start
	make docker-init-db-full
	make docker-link-storage

docker-connect: 
	docker exec -it newbie bash

init-app:
	cp .env.example .env
	composer install
	php artisan key:generate
	php artisan passport:keys --force
	php artisan migrate
	php artisan db:seed
	php artisan storage:link

docker-init:
	git submodule update --init
	docker exec -it newbie-api make init-app
	rm -rf node_modules
	npm install

init-db-full:
	make autoload
	php artisan migrate:fresh
	make update-master
	php artisan db:seed
	./bin/import_seed_data.sh

gen-i18n:
	php artisan vue-i18n:generate

docker-gen-i18n:
	docker exec -it newbie-api make gen-i18n

docker-init-db-full:
	docker exec -it newbie-api make init-db-full

docker-link-storage:
	docker exec -it newbie-api php artisan storage:link

init-db:
	make autoload
	php artisan migrate:fresh

start:
	php artisan serve

log:
	tail -f storage/logs/laravel.log

test-js:
	npm test

test-php:
	vendor/bin/phpcs --standard=phpcs.xml && vendor/bin/phpmd app text phpmd.xml

build:
	npm run dev

watch:
	npm run watch

docker-watch:
	docker exec -it newbie-api make watch

autoload:
	composer dump-autoload

cache:
	php artisan cache:clear && php artisan view:clear

docker-cache:
	docker exec newbie-api make cache

route:
	php artisan route:list

generate-master:
	php bin/generate_master.php $(lang)

update-master:
	php artisan master:update $(lang)
	make cache

deploy:
	ssh $(u)@$(h) "mkdir -p $(dir)"
	rsync -avhzL --delete \
				--no-perms --no-owner --no-group \
				--exclude .git \
				--exclude .idea \
				--exclude .env \
				--exclude laravel-echo-server.json \
				--exclude storage/*.key \
				--exclude node_modules \
				--exclude /vendor \
				--exclude bootstrap/cache \
				--exclude storage/logs \
				--exclude storage/framework \
				--exclude storage/app \
				--exclude public/storage \
				--exclude .env.example \
				. $(u)@$(h):$(dir)/
	scp storage/oauth-private.key $(u)@$(h):$(dir)/storage/
	scp storage/oauth-public.key $(u)@$(h):$(dir)/storage/

connect-master:
	ssh root@52.78.104.238

connect-slave:
	ssh root@160.16.50.160

init-db-dev:
	ssh $(u)@192.168.1.20$(n) "cd /var/www/trading/ && make init-db-full"

deploy-dev:
	make deploy h=192.168.1.205 dir=/var/www/newbie$(n)-api
	ssh $(u)@192.168.1.205 "cd /var/www/newbie$(n)-api && make cache && ./bin/queue/restart_all.sh && php artisan passport:keys --force"

deploy-staging:
	make deploy u=mangoco_exchange h=13.67.44.0 dir=/var/www/mangoex-api
	ssh mangoco_exchange@13.67.44.0 "cd /var/www/mangoex-api && make cache && ./bin/queue/restart_all.sh"

deploy-vcc:
	make deploy u=root h=vcc.exchange dir=/var/www/trading
	ssh root@vcc.exchange "cd /var/www/trading && make cache && php artisan passport:keys --force && ./bin/queue/restart_all.sh"

# deploy-staging:
# 	make deploy u=root h=13.250.31.83 dir=/root/vcc
# 	ssh root@13.250.31.83 "cd /root/vcc\
# 		&& composer install\
# 		&& npm install\
# 		&& composer dump-autoload\
# 		"
# 	ssh root@13.250.31.83 "cd /root/deploy-staging\
# 		&& ./deploy_all.sh\
# 		"

compile:
	ssh $(u)@$(h) "cd $(dir) && npm install && composer install && make cache && make autoload && npm run production"

deploy-dev-full:
	make deploy h=192.168.1.205 dir=/var/www/aisx$(n)
	make compile h=192.168.1.205 dir=/var/www/aisz$(n)

deploy-production-full:
	make deploy server=52.78.104.238 u=root dir=/root/trading
	make compile server=52.78.104.238 u=root dir=/root/trading
	ssh root@52.78.104.238 "rsync -avhzL --delete --no-perms --no-owner --no-group \
																	--exclude .env \
																	--exclude public/storage \
																	--exclude bootstrap/cache \
																	--exclude storage/logs \
																	--exclude storage/framework \
																	--exclude storage/app \
																	/root/trading/* /var/www/trading/"
	ssh root@52.78.104.238 "cd /var/www/trading/ && make cache"
