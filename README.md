# Welcome to PHP MVC Structure by TanHongIT

# 1. Configuration requirements

    - Version PHP 7.2 and above
    - OpenSSL PHP Extension

# 2. Technology
- Pure PHP language
- Using MVC model

# 3. Setup assets folder

This Project is using webpack in order to compile Javascript modules and compile Sass/SCSS files to css. Run the following commands in the project's asset directory:

Run:

```shell
cd public/frontend/assets
npm install
npm run build
```

# 4. Edit Connect Database

You need to change the connection information to the database after you have cloned my repository so that the website can work.

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'chatapp-php');
```