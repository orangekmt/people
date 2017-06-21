This tool will help on people management

Install
_______
For Linux Ubuntu
1) Install LAMP with
```
    sudo apt-get update
    sudo apt-get install apache2 php5 mysql-server libapache2-mod-php5 php5-mysql
    ```
2) Install PHPmyadmin
```
    sudo apt-get install phpmyadmin
    ```
3) Changed owner and group of www with
```
    sudo chgrp -R <user> /var/www/html/
    sudo chown -R <user> /var/www/html/
    sudo chmod a+w -R /var/www/html/bootstrap/cache/
    sudo chmod a+w -R /var/www/html/storage/
    ```
4) Install Git
```
    sudo apt-get install git
    ```
5) Install the application
```
    sudo git clone https://github.com/starcraft04/people/ .
    ```
6) Install composer
```
    sudo apt-get install composer
    ```
7) Execute composer to install necessary applications for Laravel 5
```
    sudo composer install
    sudo composer update
    ```
8) Rename .env.example into .env with
```
    mv .env.example .env
    ```
9) Go in phpmyadmin and create a database people
10) Edit .env
    > Enter information about MySQL database
11) restart apache
```
    sudo service apache2 restart
    ```
12) Create a key
```
    sudo php artisan key:generate
    ```
13) Edit /etc/apache2/apache2.conf
    > change from
    ```
    <Directory /var/www/>
            Options Indexes FollowSymLinks
            AllowOverride None
            Require all granted
    </Directory>
    ```
    > to
    ```
    <Directory /var/www/>
            Options FollowSymLinks
            AllowOverride All
            Allow from all
            Require all granted
    </Directory>
    ```
    Then run
    ```
    a2enmod rewrite
    ```
    then restart apache by:
    ```
    sudo service apache2 restart
    ```
14) Go to .../public/niceartisan/

  >  do migrate
  >  do db seed
    If reset is not working, do
  > php composer dump-autoload
15) Modify your php.ini file (for php 7, located at: /etc/php/7.0/apache2/php.ini)
```
    Upload_max_filesize  - 15 M
    Max_input_time  - 600
    Memory_limit    - 128M
    Max_execution_time -  600
    Post_max_size - 15 M
    ```
16) Install zip support for the Excel file module to work
```
    sudo apt-get install php7.0-zip
    sudo service apache2 restart
    ```
