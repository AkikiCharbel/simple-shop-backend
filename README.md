# Laravel Product Project

This is a Laravel project that provides a list of products and users. The admin user is `admin@admin.com` and the password is `password`. There are also 10 other users with the email addresses `user-0@example.com`
to `user-9@example.com` and the password `password`. You will also find a postman collection in `/postman` so you can test all the APIs

## Getting Started

To get started with this project, follow these steps:

1. Clone the repository to your local machine:
`git clone git@github.com:AkikiCharbel/DIM-assessment.git`
2. Install the project dependencies:
`composer install`
3. Create a new `.env` file by copying the example file:
`cp .env.example .env`
4. Generate a new application key:
   `php artisan key:generate`
5. Configure your database connection in the `.env` file. By default, the `.env.example` file is configured for Valet. If you're not using Valet, you'll need to update the `APP_URL` and `DB_*` variables to match your environment.
6. Create the database and run the migrations:
   `php artisan migrate`
7. Seed the database with some sample data:
`php artisan db:seed`
This will seed the database with some sample products and users. The admin user will have the email `admin@admin.com` and the password `password`. There will be 10 other users with the email addresses `user-0@example.com` to `user-9@example.com` and the password `password`.
8. Start the development server:
`php artisan serve`
This will start the Laravel development server and make the application available at `http://localhost:8000`.

## Usage

After following the steps above, you can access the application by visiting `http://localhost:8000` in your web browser.

## Useful Command
`composer run phpstan` phpstan will check the code for errors

`composer run pint` pint will fix the code indentation 


