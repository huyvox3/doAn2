# 📚 Laravel Web Application - Sport Ecommerce Website 

This is a Laravel-based web application developed as part of a software project or coursework. The project follows the MVC architecture provided by Laravel and includes functionalities such as user authentication, routing, database integration, and templating.

> ⚠️ **Note:** This repository has been archived and is in a read-only state. Feel free to clone or fork for educational purposes.

---

## 📌 Features

- 🧑‍💻 Built with Laravel 8+
- 🔐 Authentication and user session management
- 🗃️ MVC structure (Models, Views, Controllers)
- 🛠️ Artisan command-line support
- 🌐 RESTful routing
- 🧪 PHPUnit for testing
- 📄 Blade templating engine
- 📦 Composer for PHP dependency management
- 🧰 npm & Laravel Mix for frontend asset management

---

## 🛠️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/huyvox3/doAn2.git
cd doAn2
```

### 2. Install dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` to configure your database and other environment settings.

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Start the development server

```bash
php artisan serve
```

Open your browser and go to `http://localhost:8000`.

---

## 📁 Project Structure

```
doAn2/
├── app/             # Application logic (Controllers, Models, Policies)
├── bootstrap/       # Application bootstrap files
├── config/          # Configuration files
├── database/        # Migrations, Factories, Seeders
├── public/          # Public assets and index.php
├── resources/       # Views, Sass, JS
├── routes/          # Web and API route definitions
├── storage/         # Cache, logs, and compiled views
├── tests/           # Unit and feature tests
├── .env.example     # Example environment variables
├── composer.json    # PHP dependencies
├── package.json     # JS dependencies
└── artisan          # Laravel CLI
```

---

## 🧪 Testing

Run unit tests using:

```bash
php artisan test
```

Or with PHPUnit:

```bash
vendor/bin/phpunit
```

---

## 👨‍💻 Author

- **Võ Tấn Huy** — [@huyvox3 on GitHub](https://github.com/huyvox3)

---

## 📄 License

> This project does not include a license. All rights are reserved by the author.

---

## 🙋‍♂️ Contributing

This repo is archived. If you fork it and build on top, feel free to give credit and share your work!
