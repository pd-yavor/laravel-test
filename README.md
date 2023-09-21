## Laravel test cashier

In this test, I have used Laravel 10, Cashier 13, Spatie, and Breeze.

I have used Stripe with stripe-js to implement the checkout function.

I have used Laravel Breeze to implement the login function.

To register you need to make a first purchase. After that, you can log in with the password that comes with your email.

All emails are sent to the log file. You can find them in `storage/logs/laravel.log`.

The project was run under Laravel Sail on Windows 10 (wsl2).

For testing webhook(*charge.refund* only) local stripe cli was used. *Refund request located in dashboard.*

**Don't forget** to change the `.env` file with your Stripe keys.

Make sure you have run `composer install` ,`npm install`, `php artisan migrate` and `php artisan db:seed` before running the project.

**NEED TO BE RUN** `npm run dev`

** Admin account details can be seen in** `database/seeders/UserSeeder.php`
