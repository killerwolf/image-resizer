#Vagrant + Phalcon

This is a simple vagrant setup to get loaded with core development tools
to build a powerful PHP application primary focused on **Phalcon Framework**.

## Overview

We use the default Ubuntu Precise 32-bit ISO from Vagrant for compatibility.
If you choose to use a 64-bit ISO you may need to update your BIOS to enable virtualization with AMD-V or Intel VT.

When you provision Vagrant for the first time it's always the longest procedure (`$ vagrant up`). Vagrant will download the entire Linux OS if you've never used Vagrant or the Precise32 Box. Afterwards, booting time is fast.

By default this setup uses 500MB RAM. You can change this in `Vagrantfile` and simply run `$ vagrant reload`. You can also use more than one core if you like, simply uncomment these two lines in the same file:

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
  - MySQL 5.5
- Git
- [Phalcon](http://phalconphp.com/en/)
- [Phalcon DevTools](https://github.com/phalcon/phalcon-devtools)
- [Redis 2.8](http://redis.io/)
- [MongoDB 2.0.4](https://www.mongodb.org/)
- [Composer (PHP)](https://getcomposer.org)

# Installation Instructions

First **clone this repository** locally.

    $ git clone https://github.com/phalcon/vagrant.git

For newer versions of Vagrant and VirtualBox you may need guest additions, so install the plugin:

    # For Linux/OSX
    $ vagrant plugin install vagrant-vbguest

    # For Windows
    $ vagrant plugin install vagrant-windows

Now you are ready to provision with:

    $ vagrant up

The `init.sh` script will provision the system with everything needed. Take a look
inside if you want to change any default settings. Once provisioned, to access the box, simply type:

    $ vagrant ssh

    # To exit type:
    $ exit

If you want to change your bound address (`192.168.5.0` is the default), edit the `Vagrantfile` and run:

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

To create a project type the following, I'll create one called `superstar` for this example:

    $ phalcon project superstar

This will create a folder called `superstar` with all your Phalcon files. At this
point you have a folder at `/vagrant/www/superstar` and your VirtualHost will need
to point to `/vagrant/www/superstar/public`

## Create a VirtualHost for a new Phalcon Project:

You can have multiple Phalcon projects in subfolders. Make sure to keep your base
VirtualHost enabled, in our case it's the `vagrant.conf` enabled by default. Then follow the instructions below and take note, you must include the `ServerPath /project/` in your VirtualHost's.

**Do not include a ServerPath for the base vagrant.conf VirtualHost.**

    $ touch superstar.conf

Then include the following data (Notice the two directory paths with `superstar`)

    <VirtualHost *:80>
        DocumentRoot /vagrant/www/superstar/public
        ServerPath /superstar
    </VirtualHost>

    <Directory "/vagrant/www/superstar/public">
        Options Indexes Followsymlinks
        AllowOverride All
        Require all granted
    </Directory>

Next move your VirtualHost configuration file to sites-available in Apache:

    $ sudo mv superstar.conf /etc/apache2/sites-available

Lastly, you must enable your configuration file and restart apache

    $ sudo a2ensite superstar
    $ sudo service apache2 reload

If you wanted to disable a site:

    $ sudo a2dissite superstar
    $ sudo service apache2 reload

You should be able to access the following URL's:

    http://192.168.5.0/
    http://192.168.5.0/superstar

# Work on your Projects Locally

Simply go to your Host computer and open any file explorer or IDE you use, and
open any folder in `/www/`, this is mounted to the Virtual Machine and you'll have
realtime changes.

# Working within SSH

Files in the shared directory of `www` are by default given ownership of `www-data:www-data` so
that you will have no problems with saving cached files. Even with the `vagrant` user within
the `www-data` group, and even with `0777` write permissions I could't get the cache to save.

So this simply means, if you edit things in the `www` folder you must run `sudo command` to do so.

# Software Suggestions

If you are using Linux you can use the built in Terminal to do everything.
The same goes with OSX.

For Windows, you can use [Git SCM](http://git-scm.com/) and Bash.
