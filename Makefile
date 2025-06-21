# Makefile for Personal Branding Website

# Variables
DOCKER_COMPOSE = docker-compose
DOCKER_COMPOSE_PROD = docker-compose -f docker-compose.prod.yml
PHP = php
COMPOSER = composer
NPM = npm
ARTISAN = $(PHP) artisan
DOCKER_PHP = $(DOCKER_COMPOSE) exec app php
DOCKER_COMPOSER = $(DOCKER_COMPOSE) exec app composer
DOCKER_NPM = $(DOCKER_COMPOSE) exec app npm
DOCKER_ARTISAN = $(DOCKER_COMPOSE) exec app php artisan
DOCKER_PHP_PROD = $(DOCKER_COMPOSE_PROD) exec app php
DOCKER_COMPOSER_PROD = $(DOCKER_COMPOSE_PROD) exec app composer
DOCKER_NPM_PROD = $(DOCKER_COMPOSE_PROD) exec app npm
DOCKER_ARTISAN_PROD = $(DOCKER_COMPOSE_PROD) exec app php artisan

# Windows compatibility
ifeq ($(OS),Windows_NT)
    COPY = copy
    RM = del /Q
    MKDIR = mkdir
    SHELL = cmd.exe
else
    COPY = cp
    RM = rm -f
    MKDIR = mkdir -p
    SHELL = /bin/bash
endif

# Colors (will only work on Unix-like systems)
ifeq ($(OS),Windows_NT)
    GREEN =
    NC =
else
    GREEN = \033[0;32m
    NC = \033[0m # No Color
endif

# Help
.PHONY: help
help:
	@echo "$(GREEN)Personal Branding Website Makefile$(NC)"
	@echo "Available commands:"
	@echo ""
	@echo "$(GREEN)Docker Build & Run:$(NC)"
	@echo "  make docker-build       - Build Docker containers"
	@echo "  make docker-up          - Start Docker containers"
	@echo "  make docker-down        - Stop Docker containers"
	@echo "  make docker-rebuild     - Rebuild Docker containers from scratch"
	@echo "  make docker-logs        - View Docker logs"
	@echo "  make docker-shell       - Access the app container shell"
	@echo ""
	@echo "$(GREEN)Docker Development:$(NC)"
	@echo "  make dev                - Start development environment with Docker"
	@echo "  make prod               - Build and deploy production environment with Docker"
	@echo ""
	@echo "$(GREEN)Production Commands:$(NC)"
	@echo "  make prod-down          - Stop production Docker containers"
	@echo "  make prod-logs          - View production Docker logs"
	@echo "  make prod-shell         - Access production app container shell"
	@echo ""
	@echo "$(GREEN)Optimization:$(NC)"
	@echo "  make docker-optimize    - Optimize the application for production in Docker"
	@echo "  make docker-clear       - Clear application cache in Docker"
	@echo ""

# Docker Build & Run
.PHONY: docker-build
docker-build:
	@echo "$(GREEN)Building Docker containers...$(NC)"
	$(DOCKER_COMPOSE) build

.PHONY: docker-up
docker-up:
	@echo "$(GREEN)Starting Docker containers...$(NC)"
	$(DOCKER_COMPOSE) up -d
	@echo "$(GREEN)Your application is running at: http://localhost:4001$(NC)"

.PHONY: docker-down
docker-down:
	@echo "$(GREEN)Stopping Docker containers...$(NC)"
	$(DOCKER_COMPOSE) down

.PHONY: docker-rebuild
docker-rebuild:
	@echo "$(GREEN)Rebuilding Docker containers from scratch...$(NC)"
	$(DOCKER_COMPOSE) down
	$(DOCKER_COMPOSE) build --no-cache
	$(DOCKER_COMPOSE) up -d
	@echo "$(GREEN)Your application is running at: http://localhost:4001$(NC)"

.PHONY: docker-logs
docker-logs:
	$(DOCKER_COMPOSE) logs -f

.PHONY: docker-shell
docker-shell:
	$(DOCKER_COMPOSE) exec app bash

# Docker Development
.PHONY: dev
dev: docker-env docker-up
	@echo "$(GREEN)Setting up development environment...$(NC)"
	$(DOCKER_COMPOSER) install --no-interaction
	$(DOCKER_ARTISAN) key:generate --no-interaction --force
	$(DOCKER_ARTISAN) migrate --no-interaction --force
	$(DOCKER_NPM) install --no-interaction
	$(DOCKER_NPM) run dev
	@echo "$(GREEN)Development environment is ready!$(NC)"
	@echo "$(GREEN)Your application is running at: http://localhost:4001$(NC)"

.PHONY: prod
prod: docker-env-prod
	@echo "$(GREEN)Building and deploying production environment...$(NC)"
	$(DOCKER_COMPOSE_PROD) build
	$(DOCKER_COMPOSE_PROD) up -d
	@echo "$(GREEN)Running database migrations...$(NC)"
	$(DOCKER_ARTISAN_PROD) migrate --no-interaction --force
	@echo "$(GREEN)Production environment is ready!$(NC)"
	@echo "$(GREEN)Your application is running at: http://localhost:4001$(NC)"
	@echo "$(GREEN)Note: The production environment is optimized for performance and security.$(NC)"

# Docker Environment Setup
.PHONY: docker-env
docker-env:
	@echo "$(GREEN)Setting up Docker development environment...$(NC)"
ifeq ($(OS),Windows_NT)
	@if not exist .env ($(COPY) .env.example .env)
	@echo "$(GREEN)Note: On Windows, you may need to manually update your .env file with the following settings:$(NC)"
	@echo "DB_HOST=db"
	@echo "DB_PASSWORD=root"
	@echo "REDIS_HOST=redis"
	@echo "MYSQL_DATABASE=personal_laravel"
	@echo "MYSQL_ROOT_PASSWORD=root"
	@echo "MYSQL_SERVICE_TAGS=dev"
	@echo "MYSQL_SERVICE_NAME=mysql"
else
	@if [ ! -f .env ]; then \
		$(COPY) .env.example .env; \
		sed -i 's/DB_HOST=.*/DB_HOST=db/g' .env; \
		sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/g' .env; \
		sed -i 's/REDIS_HOST=.*/REDIS_HOST=redis/g' .env; \
		sed -i 's/MYSQL_DATABASE=.*/MYSQL_DATABASE=personal_laravel/g' .env; \
		sed -i 's/MYSQL_ROOT_PASSWORD=.*/MYSQL_ROOT_PASSWORD=root/g' .env; \
		sed -i 's/MYSQL_SERVICE_TAGS=.*/MYSQL_SERVICE_TAGS=dev/g' .env; \
		sed -i 's/MYSQL_SERVICE_NAME=.*/MYSQL_SERVICE_NAME=mysql/g' .env; \
	fi
endif

.PHONY: docker-env-prod
docker-env-prod:
	@echo "$(GREEN)Setting up Docker production environment...$(NC)"
ifeq ($(OS),Windows_NT)
	@if not exist .env ($(COPY) .env.example .env)
	@echo "$(GREEN)Note: On Windows, you may need to manually update your .env file with the following settings:$(NC)"
	@echo "APP_ENV=production"
	@echo "APP_DEBUG=false"
	@echo "DB_HOST=db"
	@echo "DB_PASSWORD=root"
	@echo "REDIS_HOST=redis"
	@echo "MYSQL_DATABASE=personal_laravel"
	@echo "MYSQL_ROOT_PASSWORD=root"
	@echo "MYSQL_SERVICE_TAGS=prod"
	@echo "MYSQL_SERVICE_NAME=mysql"
else
	@if [ ! -f .env ]; then \
		$(COPY) .env.example .env; \
	fi
	@sed -i 's/APP_ENV=.*/APP_ENV=production/g' .env
	@sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/g' .env
	@sed -i 's/DB_HOST=.*/DB_HOST=db/g' .env
	@sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/g' .env
	@sed -i 's/REDIS_HOST=.*/REDIS_HOST=redis/g' .env
	@sed -i 's/MYSQL_DATABASE=.*/MYSQL_DATABASE=personal_laravel/g' .env
	@sed -i 's/MYSQL_ROOT_PASSWORD=.*/MYSQL_ROOT_PASSWORD=root/g' .env
	@sed -i 's/MYSQL_SERVICE_TAGS=.*/MYSQL_SERVICE_TAGS=prod/g' .env
	@sed -i 's/MYSQL_SERVICE_NAME=.*/MYSQL_SERVICE_NAME=mysql/g' .env
endif

# Production Commands
.PHONY: prod-down
prod-down:
	@echo "$(GREEN)Stopping production Docker containers...$(NC)"
	$(DOCKER_COMPOSE_PROD) down

.PHONY: prod-logs
prod-logs:
	@echo "$(GREEN)Viewing production Docker logs...$(NC)"
	$(DOCKER_COMPOSE_PROD) logs -f

.PHONY: prod-shell
prod-shell:
	@echo "$(GREEN)Accessing production app container shell...$(NC)"
	$(DOCKER_COMPOSE_PROD) exec app bash

# Optimization
.PHONY: docker-optimize
docker-optimize:
	@echo "$(GREEN)Optimizing application for production...$(NC)"
	$(DOCKER_ARTISAN) optimize
	$(DOCKER_ARTISAN) config:cache
	$(DOCKER_ARTISAN) route:cache
	$(DOCKER_ARTISAN) view:cache
	@echo "$(GREEN)Application optimized for production.$(NC)"

.PHONY: docker-clear
docker-clear:
	@echo "$(GREEN)Clearing application cache...$(NC)"
	$(DOCKER_ARTISAN) optimize:clear
	$(DOCKER_ARTISAN) config:clear
	$(DOCKER_ARTISAN) route:clear
	$(DOCKER_ARTISAN) view:clear
	$(DOCKER_ARTISAN) cache:clear
	@echo "$(GREEN)Application cache cleared.$(NC)"
