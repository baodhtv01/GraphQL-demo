Write-Host "🚀 GraphQL Laravel Demo Setup Script" -ForegroundColor Cyan
Write-Host "=================================" -ForegroundColor Cyan

# Build and start containers
Write-Host "📦 Building and starting Docker containers..." -ForegroundColor Yellow
docker-compose up -d --build

# Wait for MySQL to be ready
Write-Host "⏳ Waiting for database to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 30

# Install dependencies
Write-Host "📚 Installing Composer dependencies..." -ForegroundColor Yellow
docker-compose exec app composer install

# Generate app key
Write-Host "🔑 Generating application key..." -ForegroundColor Yellow
docker-compose exec app php artisan key:generate

# Run migrations
Write-Host "🗃️ Running database migrations..." -ForegroundColor Yellow
docker-compose exec app php artisan migrate

# Seed database
Write-Host "🌱 Seeding database with sample data..." -ForegroundColor Yellow
docker-compose exec app php artisan db:seed

# Publish GraphQL config
Write-Host "⚙️ Publishing GraphQL configuration..." -ForegroundColor Yellow
docker-compose exec app php artisan vendor:publish --provider="Rebing\GraphQL\GraphQLServiceProvider"

# Set permissions
Write-Host "🔐 Setting proper permissions..." -ForegroundColor Yellow
docker-compose exec app chown -R www-data:www-data /var/www
docker-compose exec app chmod -R 755 /var/www/storage

Write-Host "✅ Setup completed successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "🌐 You can now access:" -ForegroundColor Cyan
Write-Host "   - Main app: http://localhost:8000" -ForegroundColor White
Write-Host "   - GraphQL Demo: http://localhost:8000/graphql-demo" -ForegroundColor White
Write-Host "   - GraphQL API: http://localhost:8000/graphql" -ForegroundColor White
Write-Host "   - GraphiQL: http://localhost:8000/graphiql" -ForegroundColor White
Write-Host ""
Write-Host "🔍 To view logs: docker-compose logs -f" -ForegroundColor Yellow
Write-Host "🛑 To stop: docker-compose down" -ForegroundColor Yellow
