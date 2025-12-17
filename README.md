# Bookstore Application

This is a Laravel-based Bookstore application. It provides functionalities for managing books, genres, orders, and users. The project uses Filament for the administration panel.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Admin Panel](#admin-panel)
- [Contributing](#contributing)
- [License](#license)

## Prerequisites

Before you begin, ensure you have met the following requirements:
*   PHP >= 8.4
*   Composer
*   Node.js & npm (or Yarn)
*   A database (e.g., SQLite, MySQL, PostgreSQL)

## Installation

Follow these steps to set up the project locally:

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/bookstore.git
    cd bookstore
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Copy the environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your database:**
    Edit the `.env` file and set your database credentials. For SQLite, you can use:
    ```
    DB_CONNECTION=sqlite
    DB_DATABASE=/path/to/your/database.sqlite # Or database/database.sqlite
    ```

6.  **Run migrations and seed the database (optional):**
    ```bash
    php artisan migrate --seed
    ```
    This will create the necessary tables and populate them with some dummy data (if seeders are configured).

7.  **Install Node dependencies:**
    ```bash
    npm install
    # or yarn install
    ```

8.  **Compile front-end assets:**
    ```bash
    npm run dev
    # or npm run build for production
    ```

9.  **Start the local development server:**
    ```bash
    php artisan serve
    ```

    The application will be accessible at `http://127.0.0.1:8000`.

## Usage

*   Navigate to the base URL (`http://127.0.0.1:8000`) to access the public-facing bookstore.
*   You can register as a new user or log in with existing credentials.

## Admin Panel

The administration panel is built with Filament.
*   Access the admin panel at `http://127.0.0.1:8000/admin`.
*   Only users with `is_admin` set to `true` in the database can access the admin panel. You can create an admin user using a seeder or by manually updating the database.

## Contributing

Contributions are welcome! Please follow these steps:
1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/your-feature-name`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Add some feature'`).
5.  Push to the branch (`git push origin feature/your-feature-name`).
6.  Open a Pull Request.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
This application is also open-sourced under the MIT license.