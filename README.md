# Welcome to YL MVC Structure by TanHongIT

**YL MVC Structure (PHP MVC)** is a pattern made in PHP used to implement user interfaces, data, and controlling logic. 

It's built based on the combination of ideas from the **Yii framework** and **Laravel framework** (YL).

# Configuration requirements

    - PHP >= 8.0
    - OpenSSL PHP Extension

# Technology
- Pure PHP language
- Using MVC model
- Using MariaDB/MySQL database
- Webpack for compile Javascript modules and compile Sass/SCSS files to css

# Setup assets folder

This Project is using webpack in order to compile Javascript modules and compile Sass/SCSS files to css. Run the following commands in the project's asset directory:

Run:

```shell
cd public/frontend/assets
npm install
npm run build
```

# 4. Edit Connect Database

You need to change the connection information to the database if you want to store and use data for the website.

Path: [`/config/database.php.example`](https://github.com/tanhongit/yl-mvc-structure/tree/main/config)

Copy the file `database.php.example` to `database.php`.

```bash
cd config
cp database.php.example database.php
```

Edit the file `database.php` and change the following lines with your database information:

```php
const DB_HOST = '127.0.0.1'; # this is ip of mysql in your local
const DB_PORT = 3306; # this is port of mysql in your local

const DB_USER = 'root';
const DB_PASSWORD = 'rootpassword';

const DB_NAME = 'mvc-structure';
```

# 5. Install and using ssl certificate (optional)

Using **mkcert** to create ssl certificate for this project.

### Install mkcert

#### On Ubuntu

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

#### On other OS

Please refer to the instructions at the following link: [https://github.com/FiloSottile/mkcert](https://github.com/FiloSottile/mkcert)

### Create ssl certificate for this project

Run:

```shell
cd /var/www/certs
mkcert local.yl_mvc_structure.com
```

### Update configuration

Setup conf file if you are using Apache2:

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

> **_Note_**: Please make sure your local or your host has been configured to use the domain name `local.yl_mvc_structure.com` (or another domain name you want to use) to point to the project folder.

# 6. Run project

When done, you can test the website by opening the browser and typing the following URL:

```shell
http://localhost

http://localhost/product
http://localhost/product/all
http://localhost/product/show/1
http://localhost/category
...
```

> **_Note_**: If using Apache, make sure the `mod_rewrite` module is enabled.

You can also use the following command to check if the module is enabled (for Apache on Ubuntu):

```shell
sudo a2enmod rewrite
```

**If you can't enable the `mod_rewrite` module, you can use the following URL to run the project:**

```shell
http://localhost/index.php?controller=product&action=index
http://localhost/index.php?controller=product&action=all
http://localhost/index.php?controller=product&action=show&id=1
http://localhost/index.php?controller=category&action=index
```
