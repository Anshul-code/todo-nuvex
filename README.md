## TODO Laravel

Steps to install project:

1. Clone repository and run `composer install`
2. After that copy `.env.example` to `.env`  in same root directory of project.
3. Update variables for DB connection.
4. If there is no application key then generate it using `php artisan key:generate`.
5. Run all migrations `php artisan migrate`.
6. To run project locally `php artisan serve`.
