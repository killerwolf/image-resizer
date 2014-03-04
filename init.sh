#!/bin/bash
# Using Precise32 Ubuntu

sudo apt-get update
#
# For PHP 5.5
#
sudo apt-get install -y python-software-properties
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get update

#
# MySQL with root:<no password>
#
export DEBIAN_FRONTEND=noninteractive
apt-get -q -y install mysql-server

#
# PHP
#
sudo apt-get install -y php5 php5-dev apache2 libapache2-mod-php5 php5-mysql

#
# Redis
#
sudo apt-get install -y redis-server

#
# Utilities
#
sudo apt-get install -y curl htop git-core

#
# Redis Configuration
# Allow us to Remote from Vagrant with Port
#
sudo cp /etc/redis/redis.conf /etc/redis/redis.bkup.conf
sudo sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf
sudo /etc/init.d/redis-server restart

#
# MySQL Configuration
# Allow us to Remote from Vagrant with Port
#
sudo cp /etc/mysql/my.cnf /etc/mysql/my.bkup.cnf
# Note: Since the MySQL bind-address has a tab cahracter I comment out the end line
sudo sed -i 's/bind-address/bind-address = 0.0.0.0#/' /etc/mysql/my.cnf
sudo service mysql restart

#
# Composer for PHP
#
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

#
# Apache VHost
#
sudo a2enmod rewrite
cd ~
echo '<VirtualHost *:80>
        DocumentRoot /vagrant/www/public
</VirtualHost>

<Directory "/vagrant/www/public">
        Options Indexes Followsymlinks
        AllowOverride All
        Require all granted
</Directory>' > vagrant.conf

sudo mv vagrant.conf /etc/apache2/sites-available
sudo a2ensite vagrant

#
# Install PhalconPHP
# Enable it
#
cd ~
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install

echo "extension=phalcon.so" > phalcon.ini
sudo mv phalcon.ini /etc/php5/mods-available
sudo php5enmod phalcon

#
# Install PhalconPHP DevTools
#
cd ~
echo '{"require": {"phalcon/devtools": "dev-master"}}' > composer.json
composer install
rm composer.json

sudo mkdir /opt/phalcon-tools
sudo mv ~/vendor/phalcon/devtools/* /opt/phalcon-tools
sudo ln -s /opt/phalcon-tools/phalcon.php /usr/bin/phalcon
sudo rm -rf ~vendor

#
# Reload apache
#
sudo service apache2 restart

echo -e "----------------------------------------\n"
echo -e "To create a Phalcon Project:\n"
echo -e "----------------------------------------\n"
echo -e "$ cd /vagrant/www\n"
echo -e "$ phalcon project projectname\n\n"


echo -e "----------------------------------------\n"
echo -e "In our instance we only have one VHost setup\n"
echo -e "For the /vagrant/www/public folder. If you create\n"
echo -e "a project named <site> for example, you 2 \n"
echo -e "options:\n"
echo -e "  1: Create a new VHost\n"
echo -e "  2: Move the project to the already setup in \n"
echo -e "     /vagrant/www \n"
echo -e "----------------------------------------\n"
