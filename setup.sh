#!/bin/bash

# Puskesmas Laravel Migration Setup Script

echo "================================"
echo "Puskesmas Laravel Setup Script"
echo "================================"
echo ""

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer first."
    exit 1
fi

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP first."
    exit 1
fi

echo "✓ Prerequisites found"
echo ""

# Install composer dependencies
echo "📦 Installing composer dependencies..."
composer install

# Generate app key
echo ""
echo "🔑 Generating application key..."
php artisan key:generate

# Setup environment file
echo ""
echo "⚙️  Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✓ .env file created"
else
    echo "✓ .env file already exists"
fi

# Dump autoload
echo ""
echo "🔄 Dumping autoloader..."
composer dump-autoload

echo ""
echo "✅ Setup completed!"
echo ""
echo "Next steps:"
echo "1. Make sure MySQL is running"
echo "2. Import database: mysql -u root -p123 < database/puskesmas.sql"
echo "3. Run: php artisan serve"
echo "4. Visit: http://localhost:8000"
echo ""
