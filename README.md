# Welcome to YL MVC Structure by TanHongIT

**YL MVC Structure (PHP MVC)** is a pattern made in PHP used to implement user interfaces, data, and controlling logic. 

It's built based on the combination of ideas from the Yii framework and Laravel framework (yl).

# 1. Configuration requirements

    - Version PHP 7.2 and above (latest - 8.1)
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

You need to change the connection information to the database if you want to store and use data for the website.

Path: [`/config/database.php.example`](https://github.com/TanHongIT/yl-mvc-structure/tree/main/config)

Copy the file `database.php.example` to `database.php` and edit the information in the file.

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mvc-structure');
```

# 5. Install and using ssl certificate

Using **mkcert** to create ssl certificate

### On Ubuntu

```shell
sudo apt install libnss3-tools

sudo wget https://github.com/FiloSottile/mkcert/releases/download/v1.4.3/mkcert-v1.4.3-linux-amd64 && \
sudo mv mkcert-v1.4.3-linux-amd64 mkcert && \
sudo chmod +x mkcert && \
sudo cp mkcert /usr/local/bin/
```

Now that the mkcert utility is installed, run the command below to generate and install your local CA:

```shell
mkcert -install
```

### Create ssl certificate for this project

Run:

```shell
cd /var/www/certs
mkcert local.yl_mvc_structure.com
```

### Update configuration

Setup conf file using Apache:

Change **local.yl_mvc_structure.com.conf** file (/apache2/sites-available/ to this)

```
<VirtualHost *:80>
	ServerAdmin localserver@localhost
	ServerName local.yl_mvc_structure.com
	ServerAlias www.yl_mvc_structure.vdx.com
	DocumentRoot /var/www/yl_mvc_structure
	ErrorLog /var/www/logs/error-yl_mvc_structure.log
    CustomLog /var/www/logs/access-yl_mvc_structure.log combined
</VirtualHost>

<VirtualHost *:443>
    ServerAdmin localserver@localhost
    ServerName local.yl_mvc_structure.com
    ServerAlias www.local.yl_mvc_structure.com
    DocumentRoot /var/www/yl_mvc_structure

    ErrorLog /var/www/logs/error-yl_mvc_structure.log
    CustomLog /var/www/logs/access-yl_mvc_structure.log combined

    SSLEngine on
	SSLCertificateFile /var/www/certs/local.yl_mvc_structure.com.pem
	SSLCertificateKeyFile /var/www/certs/local.yl_mvc_structure.com-key.pem

    <Directory /var/www/yl_mvc_structure>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

When done, you can test the website by opening the browser and typing the following URL:

```shell
https://local.yl_mvc_structure.com

https://local.yl_mvc_structure.com/product
https://local.yl_mvc_structure.com/product/all
https://local.yl_mvc_structure.com/product/show/1
...
```
