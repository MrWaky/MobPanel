# MobPanel

A game server management panel based on Pterodactyl Panel, designed to be lightweight and portable.

## Features

- Game server management
- User-friendly interface
- Runs without Docker or systemctl dependencies
- Portable deployment options

## Setup Options

### Option 1: Standard Installation

```bash
git clone https://github.com/MrWaky/MobPanel.git
cd MobPanel
```

### Option 2: Portable Installation (No Docker or systemctl)

This method allows you to run MobPanel without system service management or Docker containers.

#### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL/MariaDB
- Node.js and npm

#### Installation Steps

1. Clone the repository:

```bash
git clone https://github.com/MrWaky/MobPanel.git
```

2. Navigate to the project directory:

```bash
cd MobPanel
```

3. Install PHP dependencies:

```bash
composer install --no-dev --optimize-autoloader
```

4. Install Node.js dependencies:

```bash
npm install
npm run build
```

5. Copy the environment file:

```bash
cp .env.example .env
```

6. Generate application key:

```bash
php artisan key:generate
```

7. Configure your database in the `.env` file:
   - Set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`

8. Run database migrations:

```bash
php artisan migrate
```

9. Create the first admin user:

```bash
php artisan p:user:make
```

10. Set proper permissions:

```bash
chmod -R 755 storage/* bootstrap/cache
```

## Running MobPanel (No systemctl)

Instead of using systemctl, you can run MobPanel directly:

1. Start the web server:

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

2. In a separate terminal, run the queue worker:

```bash
php artisan queue:work
```

3. In another terminal, run the scheduler (if needed):

```bash
while true; do php artisan schedule:run; sleep 60; done
```

Access the panel at: http://your-server-ip:8080

## Configuration

Detailed configuration options can be found in the `.env` file. Key settings include:

- `APP_URL`: Your panel's URL
- `DB_*`: Database connection details
- `MAIL_*`: Email settings for notifications

## Troubleshooting

- **Database Connection Issues**: Verify your database credentials in the `.env` file
- **Permission Problems**: Ensure storage and cache directories are writable
- **Port Conflicts**: If port 8080 is in use, change the port in the serve command

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software.
