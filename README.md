## Laravel test cashier

In this test I have used Laravel 10, Cashier 13,  Spatie, Breeze.

I have used Stripe with stripe-js to implement checkout function.

I have used Laravel Breeze to implement login function.

To register you need to make first purchase. After that you can login with password that come with email. 

All emails are sent to log file. You can find them in `storage/logs/laravel.log`

Project was run under `Laravel Sail` on Windows 10 (wsl2).

For testing webhook(*charge.refund* only) localy `stripe cli` was used. *Refund request located in dashboard.*

**DONT FORGET** to change `.env` file with your Stripe keys.

Make sure you have run `composer install` ,`npm install`, `php artisan migrate` and `php artisan db:seed` before running project.

### NEED TO BE RUN `npm run dev`

### Admin account details you can see in `database/seeders/UserSeeder.php`


