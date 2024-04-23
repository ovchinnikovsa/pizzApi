include .env

run:
	docker-compose -f docker-compose-dev.yml up -d

up:
	docker-compose -f docker-compose-dev.yml up

stop:
	docker-compose -f docker-compose-dev.yml down

build:
	docker-compose -f docker-compose-dev.yml build

clean:
	docker system prune -a --volumes

composer-install:
	docker-compose exec --user root app composer install

composer-autoload:
	docker-compose exec --user root app composer dump-autoload

composer-update:
	docker-compose exec --user root app composer update

db_dump:
	docker-compose exec mariadb sh -c "exec mariadb-dump -uroot \
	-p$(MARIADB_ROOT_PASSWORD) $(MARIADB_DATABASE) > /var/backups/db.sql"

db_restore:
	docker-compose exec -i mariadb sh -c "exec mysql --user=root \
	--password=$(MARIADB_ROOT_PASSWORD) $(MARIADB_DATABASE) < /var/backups/db.sql"

prod_run:
	docker-compose -f docker-compose.yml up -d

prod_up:
	docker-compose -f docker-compose.yml up

prod_stop:
	docker-compose -f docker-compose.yml down

prod_build:
	docker-compose -f docker-compose.yml build
