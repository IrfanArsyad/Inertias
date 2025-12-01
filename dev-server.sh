#!/bin/bash

# Development Server Startup Script
# Starts both Laravel and Vite dev servers

echo "🚀 Starting Development Servers..."
echo ""

# Check if servers are already running
if lsof -ti:8000 > /dev/null 2>&1; then
    echo "⚠️  Port 8000 is already in use. Stopping existing process..."
    kill $(lsof -ti:8000) 2>/dev/null
    sleep 1
fi

if lsof -ti:5173 > /dev/null 2>&1; then
    echo "⚠️  Port 5173 is already in use. Stopping existing process..."
    kill $(lsof -ti:5173) 2>/dev/null
    sleep 1
fi

# Clear caches for development
echo "🧹 Clearing caches..."
php artisan config:clear > /dev/null 2>&1
php artisan route:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1
echo "✅ Caches cleared"
echo ""

# Start Laravel server in background
echo "📡 Starting Laravel server (port 8000)..."
php artisan serve --host=127.0.0.1 --port=8000 > /dev/null 2>&1 &
LARAVEL_PID=$!
sleep 2

# Check if Laravel started successfully
if ! lsof -ti:8000 > /dev/null 2>&1; then
    echo "❌ Failed to start Laravel server"
    exit 1
fi
echo "✅ Laravel server running (PID: $LARAVEL_PID)"
echo ""

# Start Vite dev server in background
echo "⚡ Starting Vite dev server (port 5173)..."
npm run dev > /dev/null 2>&1 &
VITE_PID=$!
sleep 3

# Check if Vite started successfully
if ! lsof -ti:5173 > /dev/null 2>&1; then
    echo "❌ Failed to start Vite server"
    kill $LARAVEL_PID 2>/dev/null
    exit 1
fi
echo "✅ Vite dev server running (PID: $VITE_PID)"
echo ""

echo "═══════════════════════════════════════"
echo "✅ DEVELOPMENT SERVERS READY!"
echo "═══════════════════════════════════════"
echo ""
echo "🌐 Application URL: http://localhost:8000"
echo "⚡ Vite HMR:        http://localhost:5173"
echo ""
echo "📝 Server PIDs:"
echo "  Laravel: $LARAVEL_PID"
echo "  Vite:    $VITE_PID"
echo ""
echo "🛑 To stop servers, run: ./stop-dev.sh"
echo "   Or press Ctrl+C and kill the PIDs above"
echo ""
echo "📊 Monitoring..."
echo ""

# Save PIDs for stop script
echo "$LARAVEL_PID" > .laravel.pid
echo "$VITE_PID" > .vite.pid

# Keep script running to show logs
trap "echo ''; echo '🛑 Stopping servers...'; kill $LARAVEL_PID $VITE_PID 2>/dev/null; rm -f .laravel.pid .vite.pid; echo '✅ Servers stopped'; exit" INT TERM

# Follow logs
tail -f storage/logs/laravel.log 2>/dev/null &
wait
