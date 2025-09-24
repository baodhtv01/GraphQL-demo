#!/bin/bash

echo "🚀 GraphQL Laravel Demo Setup Script"
echo "================================="

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "📄 Creating .env file from .env.example..."
    cp .env.example .env
    echo "✅ .env file created successfully!"
else
    echo "📄 .env file already exists, skipping creation"
fi

# Build and start containers
echo "📦 Building and starting Docker containers..."
docker-compose up -d --build

# Wait for MySQL to be ready
echo "⏳ Waiting for database to be ready..."
sleep 30

# Install dependencies
echo "📚 Installing Composer dependencies..."
docker-compose exec app composer install

# Generate app key
echo "🔑 Generating application key..."
docker-compose exec app php artisan key:generate

# Run migrations
echo "🗃️ Running database migrations..."
docker-compose exec app php artisan migrate

# Seed database
echo "🌱 Seeding database with sample data..."
docker-compose exec app php artisan db:seed

# Publish GraphQL config
echo "⚙️ Publishing GraphQL configuration..."
docker-compose exec app php artisan vendor:publish --provider="Rebing\\GraphQL\\GraphQLServiceProvider"

# Set permissions
echo "🔐 Setting proper permissions..."
docker-compose exec app chown -R www-data:www-data /var/www
docker-compose exec app chmod -R 755 /var/www/storage

echo "✅ Setup completed successfully!"
echo ""
echo "🌐 You can now access:"
echo "   - Main app: http://localhost:8000"
echo "   - GraphQL Demo: http://localhost:8000/graphql-demo"
echo "   - GraphQL API: http://localhost:8000/graphql"
echo "   - GraphiQL: http://localhost:8000/graphiql"
echo ""
echo "🔍 To view logs: docker-compose logs -f"
echo "🛑 To stop: docker-compose down"
