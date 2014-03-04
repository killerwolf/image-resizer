#Vagrant JREAM Preferred

This is a simple vagrant setup to get loaded with core development tools
to build a powerful PHP application primary focused on **PhalconPHP**.


## Overview

We use the default 32-bit ISO from Vagrant for compatibility.
If you choose to use a 64-bit ISO you may need to update your BIOS to enable virtualization with AMD-V or Intel VT.

The first time you provision (`$ vagrant up`) it takes the longest because it set's up your system. After you are
initially setup, booting up is much faster.

By default this setup uses 500MB RAM. You can change this in `Vagrantfile`. You can also
use more than one core if you like, simply uncomment these two lines in the same file:

    v.customize ["modifyvm", :id, "--cpus", "2"]
    v.customize ["modifyvm", :id, "--ioapic", "on"]

## Requirements

- Operating System: Windows, Linux, or OSX.
- [Virtualbox](https://www.virtualbox.org) version 4.3.*
- [Vagrant](http://www.vagrantup.com) version 1.4.*

## Automatically Installs

- LAMP Stack
  - Ubuntu Precise (32-Bit)
  - Apache 2
  - PHP 5.5
  - MySQL 5.5 (root:<none>)
- Git
- [PhalconPHP](http://phalconphp.com/en/)
- [PhalconPHP DevTools](https://github.com/phalcon/phalcon-devtools)
- [Redis 2.8](http://redis.io/)
- [Composer (PHP)](https://getcomposer.org)

# Installation Instructions

First **clone this repository** locally. Then run the following:

    $ vagrant up

The `init.sh` script will provision the system with everything needed. Take a look
inside if you want to change any default settings. Once privisioned, to access the box, simply type:

    $ vagrant ssh

If you want to change your bound address (`192.168.5.0` is the default), edit the `Vagrantfile` and do:

    $ vagrant reload

If you want to point your Guest Machine (Vagrant OS) to a friendly URL, you could modify your `etc/hosts` file and add the following:

    192.168.5.0  your-server-name


# Default Credentials

These are credentials setup by default:

- Host Address: 192.168.5.0
- SSH: vagrant / vagrant
- MySQL: root / (none)
- Redis: No Password

# Getting Start with PhalconDev Tools

To create your Phalcon project, head over to the default working directory:

    $ cd /vagrant/www

Then run the following command to see your options:

    $ phalcon

To create a project type the following (`superstar` will be used for this example):

    $ phalcon project superstar

This will create a folder called `superstar` with all your Phalcon files. At this
point you have a folder at `/vagrant/www/superstar` and your VirtustHost will want
to point to `/vagrant/www/superstar/public`

####You have the option of:
- Editing the `vagrant.conf` file inside `/etc/apache2/sites-available`
- Or creating another VirtualHost

## To create a VirtualHost:

    $ touch superstar.conf

Then include the following data (Notice the two directory paths with `superstar`)

    <VirtualHost *:80>
        DocumentRoot /vagrant/www/superstar/public
    </VirtualHost>

    <Directory "/vagrant/www/superstar/public">
        Options Indexes Followsymlinks
        AllowOverride All
        Require all granted
    </Directory>

Next move your VirtualHost configuration file to sites-available in Apache:

    $ sudo mv vagrant.conf /etc/apache2/sites-available

Lastly, you must enable your configuration file and restart apache

    $ sudo a2ensite superstar
    $ sudo service apache2 restart

If you wanted to disable a site:

    $ sudo a2dissite superstar

# Software Suggestions

If you are using Linux you can use the built in Terminal to do everything.
The same goes with OSX.

For Windows, I prefer using [Git SCM](http://git-scm.com/) and using the Bash.

# Guest Additions

If you have issues with Guest Additions sometimes with the newer VirtualBox and Vagrant versions, try the following on Linux/OSX:

    $ vagrant plugin install vagrant-vbguest

On Windows try:

    $ vagrant plugin install vagrant-windows
