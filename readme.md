# filExplorer

App thats allows to create isolated file explorer on your site.

## Installations

###  Requirements:
* system unix like or win with
[wsl](https://learn.microsoft.com/ru-ru/windows/wsl/install)
* installed [docker](https://www.docker.com/)
* installed [make app](https://www.gnu.org/software/make/)

### Steps to build

Run make instructions:

1. `make generate-files` to generate dirs and files
2. `make build` to build app
3. `make run` to start docker-compose
4. `make composer-install` to cast composer magic
5. `make db_restore` to restore database form backup

To stop - `make stop`
