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

create database mysuit;<br />
CREATE USER 'poney'@'localhost' IDENTIFIED BY 'neypo';<br />
GRANT ALL ON mysuit.* TO 'poney'@'localhost';<br />

## Commands

cp config.php.template config.php (replace with database settings)<br />
mysql -u denamok -p -D mysuit < setup/sql_dump.txt<br />
