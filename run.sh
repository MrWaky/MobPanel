#!/bin/bash

# MobPanel Startup Script
# This script runs MobPanel without requiring Docker or systemctl

# Function to check if a command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Check for required commands
if ! command_exists php; then
    echo "Error: PHP is not installed. Please install PHP 8.0 or higher."
    exit 1
fi

if ! command_exists composer; then
    echo "Error: Composer is not installed. Please install Composer."
    exit 1
fi

# Check if .env file exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    php artisan key:generate
    echo "Please edit the .env file to configure your database and other settings."
    exit 1
fi

# Install dependencies if vendor directory doesn't exist
if [ ! -d vendor ]; then
    echo "Installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Build assets if node_modules directory doesn't exist
if [ ! -d node_modules ] && command_exists npm; then
    echo "Installing Node.js dependencies and building assets..."
    npm install
    npm run build
fi

# Set proper permissions
chmod -R 755 storage bootstrap/cache

# Run database migrations if specified
if [ "$1" == "--migrate" ]; then
    echo "Running database migrations..."
    php artisan migrate
fi

# Start the web server
echo "Starting MobPanel web server..."
php artisan serve --host=0.0.0.0 --port=8080 &
WEB_PID=$!

# Start the queue worker
echo "Starting queue worker..."
php artisan queue:work --tries=3 &
QUEUE_PID=$!

# Start the scheduler
echo "Starting scheduler..."
while true; do
    php artisan schedule:run --verbose --no-interaction &
    sleep 60
done &
SCHEDULER_PID=$!

# Function to handle shutdown
shutdown() {
    echo "Shutting down MobPanel..."
    kill $WEB_PID $QUEUE_PID $SCHEDULER_PID
    exit 0
}

# Trap SIGINT and SIGTERM signals
trap shutdown SIGINT SIGTERM

echo "MobPanel is running!"
echo "Web server: http://localhost:8080"
echo "Press Ctrl+C to stop"

# Wait for all processes to finish
wait
