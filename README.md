# Translation Service

A high-performance translation management system built with Laravel, designed to handle enterprise-level localization needs with robust caching and CDN support.

## 🚀 Key Features

- **High Performance**: Optimized with Redis caching and index-based queries
- **RESTful API**: Clean API endpoints for translation management
- **Multi-language Support**: Handles multiple languages and locales
- **Tag System**: Organize translations with a flexible tagging system
- **CDN Integration**: AWS CloudFront integration for global content delivery
- **Docker Ready**: Containerized setup for consistent development and deployment

## 🛠 Tech Stack

- PHP 8.2
- Laravel 10
- MySQL 8.0
- Redis
- Docker & Docker Compose
- AWS S3 & CloudFront

## 🏃‍♂️ Quick Start

1. Clone and prepare the environment:


bash
git clone [your-repo]
cd translation-service
cp .env.example .env

2. Start Docker services:
```bash
docker-compose up -d
```

3. Set up the application:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

## 🔧 Configuration

### Environment Variables

Essential variables for your `.env`:
```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=translation_service
DB_USERNAME=translation_user
DB_PASSWORD=secure_password

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=your_region
AWS_BUCKET=your_bucket
CLOUDFRONT_URL=your_cdn_url
```

## 📚 API Documentation

Our RESTful API provides comprehensive endpoints for translation management. Full OpenAPI/Swagger documentation is available at `/api/documentation`.

### Key Endpoints

#### Translations
- `GET /api/v1/translations` - List translations
- `POST /api/v1/translations` - Create translation
- `PUT /api/v1/translations/{id}` - Update translation
- `DELETE /api/v1/translations/{id}` - Delete translation
- `GET /api/v1/translations/search` - Search translations

#### Languages
- `GET /api/v1/languages` - List supported languages
- `POST /api/v1/languages` - Add new language
- `DELETE /api/v1/languages/{id}` - Remove language

#### Tags
- `GET /api/v1/tags` - List translation tags
- `POST /api/v1/tags` - Create new tag
- `PUT /api/v1/tags/{id}` - Update tag
- `DELETE /api/v1/tags/{id}` - Delete tag

## 🧪 Testing

We maintain high test coverage (>95%) across the codebase:

```bash
# Run all tests
docker-compose exec app php artisan test

# Run with coverage report
docker-compose exec app php artisan test --coverage-html coverage

# Run performance tests
docker-compose exec app php artisan test --filter=TranslationPerformanceTest
```

## 🚀 Deployment

1. Configure production environment:
```bash
cp .env.example .env.production
# Update production environment variables
```

2. Build production Docker image:
```bash
docker build -t translation-service:production .
```

3. Run migrations:
```bash
docker-compose exec app php artisan migrate --force
```

## 🔍 Health Monitoring

Monitor service health at `/health-check`. Includes:
- Database connectivity
- Redis status
- Cache performance
- API response times
- Queue status

## 📈 Performance Metrics

Our service is optimized for:
- Response times < 200ms
- Cache hit ratio > 95%
- Support for 10,000+ translations
- Efficient memory usage < 50MB per process
- High concurrency support
