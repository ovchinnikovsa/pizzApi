include .env

run:
	docker-compose up -d

up:
	docker-compose up

stop:
	docker-compose down

build:
	docker-compose build

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