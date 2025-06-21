# Personal Branding Website

A modern personal branding website built with Laravel, Inertia.js, Vue.js, and Tailwind CSS. This project provides a platform for showcasing your portfolio, blog, and personal information with a clean, responsive design and an admin dashboard for content management.

## Features

- 🎨 Modern, responsive design with dark mode support
- 📱 Mobile-friendly interface
- 📊 Admin dashboard for content management
- 📝 Blog system with rich text editing
- 🖼️ Portfolio showcase with project details
- 📬 Contact form for visitor inquiries
- 🔒 Authentication system for admin access
- 🔍 SEO optimized for better visibility
- 🐳 Docker support for easy deployment

## Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Vue.js 3 with TypeScript
- **CSS Framework**: Tailwind CSS
- **SPA**: Inertia.js
- **Database**: MySQL
- **Caching**: Redis
- **Containerization**: Docker
- **Node.js**: v18.x (included in Docker image)

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- Docker and Docker Compose (for containerized deployment)

## Installation

### Local Development

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/personal-branding.git
   cd personal-branding
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=personal_branding
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Build frontend assets:
   ```bash
   npm run dev
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

10. Visit `http://localhost:8000` in your browser.

### Docker Deployment

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/personal-branding.git
   cd personal-branding
   ```

2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

3. Configure your environment variables in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=personal_laravel
   DB_USERNAME=root
   DB_PASSWORD=root

   REDIS_HOST=redis
   REDIS_PASSWORD=null
   REDIS_PORT=6379
   ```

4. Build and start the Docker containers:
   ```bash
   docker-compose up -d
   ```

5. Install dependencies and set up the application:
   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   docker-compose exec app npm install
   docker-compose exec app npm run build
   ```

6. Visit `http://localhost:4001` in your browser.

## Using the Makefile

This project includes a streamlined Makefile focused on Docker-based development and optimization.

> **Note for Windows Users**: The Makefile is designed to work on both Unix-like systems and Windows. However, some features may have limitations on Windows. On Windows, you may need to manually update your `.env` file with the Docker configuration settings as instructed.

### Available Commands

Run `make help` to see all available commands. Here are the main categories:

#### Docker Build & Run

```bash
# Build Docker containers
make docker-build

# Start Docker containers
make docker-up

# Stop Docker containers
make docker-down

# Rebuild Docker containers from scratch
make docker-rebuild

# View Docker logs
make docker-logs

# Access the app container shell
make docker-shell
```

#### Docker Development

```bash
# Start development environment with Docker
# This sets up the environment, starts containers, and prepares the app for development
make dev

# Build and deploy production environment with Docker
# This sets up the environment, builds containers, starts them, and optimizes the app for production
make prod
```

#### Optimization

```bash
# Optimize the application for production in Docker
make docker-optimize

# Clear application cache in Docker
make docker-clear
```

## Usage

### Admin Dashboard

1. Access the admin dashboard by visiting `/login` and logging in with your credentials.
2. Default admin credentials:
   - Email: admin@example.com
   - Password: password

3. From the dashboard, you can:
   - Manage your profile information
   - Add, edit, or remove portfolio items
   - Create and publish blog posts
   - View and respond to contact messages

### Customization

- **Profile**: Update your personal information, skills, and social media links in the admin dashboard.
- **Theme**: The site supports both light and dark modes, which automatically adjust based on user preference.
- **Content**: All content is manageable through the admin dashboard, no code changes required.

## Deployment

### Server Requirements

- PHP 8.2+
- MySQL 8.0+
- Nginx or Apache
- Composer
- Node.js and npm
- Docker and Docker Compose (for containerized deployment)

### Docker Production Deployment

The easiest way to deploy this application to production is using Docker:

#### Using the Deployment Scripts

This project includes deployment scripts for both Unix-like systems and Windows:

**For Unix-like systems (Linux, macOS):**
```bash
# Make the script executable
chmod +x deploy.sh

# Run the deployment script
./deploy.sh
```

**For Windows:**
```bash
# Run the deployment script
deploy.bat
```

Both scripts will:
- Check if the necessary tools are installed
- Pull the latest changes from the git repository
- Deploy the application to production using `make prod`

You can use the `--force` or `-f` flag to skip confirmation prompts:
```bash
./deploy.sh --force  # Unix-like systems
deploy.bat --force   # Windows
```

#### Manual Deployment

Alternatively, you can deploy manually:

1. Clone the repository on your production server:
   ```bash
   git clone https://github.com/yourusername/personal-branding.git
   cd personal-branding
   ```

2. Run the production deployment command:
   ```bash
   make prod
   ```

This single command will:
- Set up the environment variables for production
- Build and start the Docker containers with production optimizations
- Run database migrations

The production environment includes several optimizations:
- A production-specific Dockerfile that pre-installs dependencies and builds assets
- A production-specific Nginx configuration with enhanced security headers
- Optimized PHP settings for production
- Compressed static assets with proper cache headers
- Laravel optimizations (cached configs, routes, views)
- Reduced Docker volume mounts for better security

Your application will be available at `http://localhost:4001` (or the domain you've configured).

Additional production commands:
```bash
# Stop the production environment
make prod-down

# View production logs
make prod-logs

# Access the production app container shell
make prod-shell
```

### Manual Production Deployment

If you prefer to deploy without Docker:

1. Set up a production server with the required software.
2. Configure your web server to point to the `public` directory.
3. Set appropriate permissions:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```
4. Configure your environment variables for production:
   ```
   APP_ENV=production
   APP_DEBUG=false
   ```
5. Optimize the application:
   ```bash
   php artisan optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Testing

This project includes comprehensive tests for both backend and frontend components.

### Running Tests

To run all tests:
```bash
php artisan test
```

To run specific test suites:
```bash
# Run only unit tests
php artisan test --testsuite=Unit

# Run only feature tests
php artisan test --testsuite=Feature
```

### Test Coverage

The tests cover:
- Model operations and relationships
- API endpoints and controllers
- Authentication and authorization
- Frontend component rendering

### Creating New Tests

When adding new features, please ensure they are covered by appropriate tests:
- Use unit tests for testing isolated components
- Use feature tests for testing API endpoints and page rendering
- Follow the existing test structure and naming conventions

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Project Reference

This personal branding website project is located at `D:\personal-laravel`. To easily find and access this project in the future:

1. **Bookmark in File Explorer**: Create a shortcut to this directory on your desktop or pin it to Quick Access in File Explorer.
2. **Create a GitHub Repository**: Initialize a Git repository and push it to GitHub for easy access from anywhere:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/yourusername/personal-laravel.git
   git push -u origin main
   ```
3. **Document the Path**: Save the path `D:\personal-laravel` in a personal note or document.
4. **Project Summary**: This is a personal branding website built with Laravel, Vue.js, and Tailwind CSS, featuring a portfolio showcase, blog system, admin dashboard, and Docker support.

Last updated: May 30, 2023
