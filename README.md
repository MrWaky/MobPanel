# MobPanel

A game server management panel based on Pterodactyl Panel but designed to run without Docker or systemctl dependencies.

## Features

- Game server management
- User authentication and authorization
- Admin panel for system management
- Server console access
- Server power control (start, stop, restart)

## Requirements

- PHP 8.0 or higher
- Composer
- MySQL/MariaDB
- Node.js and NPM (optional, for asset compilation)

## Setup

1. Clone the repository:

```bash
git clone https://github.com/MrWaky/MobPanel.git
cd MobPanel
```

2. Install PHP dependencies:

```bash
composer install
```

3. Copy the environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Edit the `.env` file to configure your database connection and other settings.

5. Run the database migrations:

```bash
php artisan migrate
```

6. Create an admin user:

```bash
php artisan p:user:make
```

7. (Optional) Compile assets:

```bash
npm install
npm run build
```

## Running MobPanel

You can run MobPanel using the included shell script:

```bash
chmod +x run.sh
./run.sh
```

Or manually:

```bash
php artisan serve
```

Then visit `http://localhost:8000` in your web browser.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
