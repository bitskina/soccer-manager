# Soccer Application

This is a Laravel-based application that allows football fans to create fantasy teams and buy or sell players via a RESTful API.

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.2
- Composer
- MySQL or another compatible database
- Laravel (should be globally available via Composer)

## Installation

1. Clone the repository:

    ```bash
    git clone git@github.com:bitskina/soccer-manager.git
    cd soccer-manager
    ```

2. Install the required PHP dependencies using Composer:

    ```bash
    composer install
    ```

3. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate the application key:

    ```bash
    php artisan key:generate
    ```

5. Configure your `.env` file for the database connection (update the DB credentials).

6. Run the migrations and seed the database with default data (this will also seed a few translated countries):

    ```bash
    php artisan migrate --seed
    ```

## Running the Application

1. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

2. Access the application by visiting:

    ```
    http://localhost:8000
    ```

## Running the Queue Worker

To process background jobs (such as player transfers, team generation, etc.), you need to run the queue worker:

1. Start the queue worker in a new terminal window:

    ```bash
    php artisan queue:work
    ```

## Localization

The seeder includes a few translated countries. If you need localization, you must pass the `X-Accept-Language` header in your requests. Available languages are:

- `ka` (Georgian)
- `en` (English)

## API Documentation

You can access the documentation via `/docs` route.

## Running Tests

To run the application tests, execute the following command:

```bash
php artisan ./vendor/bin/pest
