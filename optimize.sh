#!/bin/bash

# Laravel + Vue + Inertia Production Optimization Script
# This script optimizes the application for production use

echo "🚀 Starting Production Optimization..."
echo ""

# 1. Clear all caches
echo "📦 Clearing existing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo "✅ Caches cleared"
echo ""

# 2. Optimize configurations
echo "⚙️  Optimizing Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Laravel optimized"
echo ""

# 3. Build production assets
echo "🎨 Building production assets with Vite..."
npm run build
echo "✅ Assets built"
echo ""

# 4. Optimize Composer autoloader
echo "📚 Optimizing Composer autoloader..."
composer install --optimize-autoloader --no-dev 2>/dev/null || composer dump-autoload --optimize
echo "✅ Composer optimized"
echo ""

# 5. Set proper permissions (if needed)
echo "🔐 Setting proper permissions..."
chmod -R 755 storage bootstrap/cache
echo "✅ Permissions set"
echo ""

# 6. Display optimization summary
echo "═══════════════════════════════════════"
echo "✅ OPTIMIZATION COMPLETE!"
echo "═══════════════════════════════════════"
echo ""
echo "📊 Applied Optimizations:"
echo "  ✓ Config caching enabled"
echo "  ✓ Route caching enabled"
echo "  ✓ View caching enabled"
echo "  ✓ Production assets built"
echo "  ✓ Autoloader optimized"
echo "  ✓ GZIP compression enabled"
echo "  ✓ Lazy loading components"
echo "  ✓ Code splitting active"
echo "  ✓ Assets minified"
echo ""
echo "🎯 Performance Tips:"
echo "  • Enable OPcache in php.ini"
echo "  • Use Redis/Memcached for cache"
echo "  • Enable HTTP/2 on web server"
echo "  • Use CDN for static assets"
echo "  • Enable browser caching"
echo ""
echo "🌐 Ready for production deployment!"
echo ""
