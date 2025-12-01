#!/bin/bash

# Stop Development Servers Script

echo "🛑 Stopping Development Servers..."
echo ""

# Stop by PID files if they exist
if [ -f .laravel.pid ]; then
    LARAVEL_PID=$(cat .laravel.pid)
    if ps -p $LARAVEL_PID > /dev/null 2>&1; then
        kill $LARAVEL_PID 2>/dev/null
        echo "✅ Laravel server stopped (PID: $LARAVEL_PID)"
    fi
    rm -f .laravel.pid
fi

if [ -f .vite.pid ]; then
    VITE_PID=$(cat .vite.pid)
    if ps -p $VITE_PID > /dev/null 2>&1; then
        kill $VITE_PID 2>/dev/null
        echo "✅ Vite dev server stopped (PID: $VITE_PID)"
    fi
    rm -f .vite.pid
fi

# Fallback: kill by port
if lsof -ti:8000 > /dev/null 2>&1; then
    kill $(lsof -ti:8000) 2>/dev/null
    echo "✅ Stopped process on port 8000"
fi

if lsof -ti:5173 > /dev/null 2>&1; then
    kill $(lsof -ti:5173) 2>/dev/null
    echo "✅ Stopped process on port 5173"
fi

echo ""
echo "✅ All development servers stopped"
