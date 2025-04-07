PROJECT_NAME="$(shell basename "$(PWD)")"
PROJECT_DIR="$(shell pwd)"
DOCKER_COMPOSE="$(shell which docker-compose)"
DOCKER="$(shell which docker)"
CONTAINER_PHP="php-unit"

# Цвета
G=\033[32m
Y=\033[33m
NC=\033[0m


help: ## Список команд
	@grep -E '(^[a-zA-Z_0-9-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
	| awk 'BEGIN {FS = ":.*?## "}; {printf "${G}%-24s${NC} %s\n", $$1, $$2}' \
	| sed -e 's/\[32m## /[33m/' && printf "\n";

.PHONY: help


init: generate-env up right help ## Инициализация проекта, поднятие контейнеров, установка прав

restart: down up ## Перезапуск контейнеров


sleep-5: ## Спать 5 сек
	sleep 5

up: ## Поднятие контейнеров
	docker-compose   --env-file .env up --build -d

down: ## Остановка контейнеров
	docker-compose   --env-file .env down --remove-orphans

generate-env:
	@if [ ! -f .env ]; then \
    		cp .env.example .env && \
    		sed -i "s/^DB_PASSWORD=/DB_PASSWORD=$(shell openssl rand -hex 8)/" .env; \
    	fi

.PHONY: init restart sleep-5 up down generate-env


bash: ## Войти в контейнер
	${DOCKER_COMPOSE} exec -it ${CONTAINER_PHP} /bin/bash

ps: ## Просмотр запущенных контейнеров
	${DOCKER_COMPOSE} ps

logs: ## Просмотр логов в контейнерах
	${DOCKER_COMPOSE} logs -f

.PHONY: bash ps logs

m-up: ## Создание таблицы
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php Command/create.php

m-down: ## Удаление таблицы
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php Command/drop.php

parse: ## Парсинг файла таблицы
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php Command/parse.php

.PHONY: m-up m-down


right: ## Установка прав
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} chown -R www-data:www-data .

.PHONY:  right