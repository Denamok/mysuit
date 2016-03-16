# MySuit v2.3

## Requirements

php5<br />
mysql<br />
php5-gd <br />
php5-mcrypt<br />

## Commands

git clone https://github.com/Denamok/mysuit.git<br />
cd mysuit<br />
chmod 777 upload<br />
chmod 777 upload_thumb<br />

## SQL commands

create database mysuit;
CREATE USER 'denamok'@'localhost' IDENTIFIED BY 'n7NN3Nyqtvrjrx';
GRANT ALL ON mysuit.* TO 'denamok'@'localhost';

## Commands

cp config.php.template config.php (replace with database settings)
mysql -u denamok -p -D mysuit < setup/sql_dump.txt
