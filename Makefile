# --------------------------------#
# Makefile for the "make" command
# --------------------------------#

DOCKER_DEV= docker compose

## ----- Docker dev -----
docker-run: ## docker run
	$(DOCKER_DEV) up -d

docker-ps: ## docker ps
	$(DOCKER_DEV) ps

docker-build: ## docker build
	$(DOCKER_DEV) up --force-recreate --build -d

docker-stop: ## docker stop
	$(DOCKER_DEV) stop

docker-exec: ## docker exec
	$(DOCKER_DEV) exec apache bash

docker-cpi: ## docker exec
	$(DOCKER_DEV) exec apache composer install

docker-restart: ## docker restart
	$(DOCKER_DEV) restart

docker-down: ## docker down
	$(DOCKER_DEV) down

## ----- Project code Quality -----

php-cs-fixer: ## php-cs-fixer
	$(DOCKER_DEV) exec apache vendor/bin/php-cs-fixer fix src

phpstan: ## phpstan
	$(DOCKER_DEV) exec apache vendor/bin/phpstan analyse src --configuration=phpstan.dist.neon

phpunit: ## phpunit
	$(DOCKER_DEV) exec apache vendor/bin/phpunit --configuration phpunit.xml.dist --colors=always

## ----- Project -----
init: ## Initialize the project
	$(DOCKER_DEV) exec apache composer install

shell: ## Enter to apache container
	$(DOCKER_DEV) exec apache bash

## ----- Help -----
help: ## Display this help
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'