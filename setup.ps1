# Puskesmas Laravel Migration Setup Script for Windows

Write-Host "================================" -ForegroundColor Cyan
Write-Host "Puskesmas Laravel Setup Script" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Check if composer is installed
try {
    $composer = composer --version
    Write-Host "✓ Composer found: $composer" -ForegroundColor Green
}
catch {
    Write-Host "❌ Composer is not installed. Please install Composer first." -ForegroundColor Red
    exit 1
}

# Check if PHP is installed
try {
    $php = php --version | Select-Object -First 1
    Write-Host "✓ PHP found: $php" -ForegroundColor Green
}
catch {
    Write-Host "❌ PHP is not installed. Please install PHP first." -ForegroundColor Red
    exit 1
}

Write-Host ""

# Install composer dependencies
Write-Host "📦 Installing composer dependencies..." -ForegroundColor Yellow
composer install

# Generate app key
Write-Host ""
Write-Host "🔑 Generating application key..." -ForegroundColor Yellow
php artisan key:generate

# Setup environment file
Write-Host ""
Write-Host "⚙️  Setting up environment..." -ForegroundColor Yellow
if (!(Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "✓ .env file created" -ForegroundColor Green
}
else {
    Write-Host "✓ .env file already exists" -ForegroundColor Green
}

# Dump autoload
Write-Host ""
Write-Host "🔄 Dumping autoloader..." -ForegroundColor Yellow
composer dump-autoload

Write-Host ""
Write-Host "✅ Setup completed!" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "1. Make sure MySQL is running"
Write-Host "2. Import database: mysql -u root -p123 < database/puskesmas.sql"
Write-Host "3. Run: php artisan serve"
Write-Host "4. Visit: http://localhost:8000"
Write-Host ""
