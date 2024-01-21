# invoices_new
This is a simple Laravel project to create a invoices application. You can create, view, edit, delete, and save them as pdf to send them as attachments. I used bulma for a better looking interface and jquery for the frontend.

Clone the repository. Run: git clone git@github.com:fraktal12/invoices.git
Install Composer Dependencies. Run: $ composer install
Install NPM Dependencies. Run: $ npm install
Create a copy of your .env file. Run: $ cp .env.example .env
Generate an app encryption key. Run: $ php artisan key:generate
Create an empty database for our application.
In the .env file, add database information to allow Laravel to connect to the database
Migrate the database. Run: $ php artisan migrate
