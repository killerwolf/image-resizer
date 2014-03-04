#Vagrant JREAM Preferred

This is a simple vagrant setup to get loaded with some basics.

## Requirements

- Virtualbox 4.3.* [https://www.virtualbox.org]
- Vagrant 1.4.* and up [http://www.vagrantup.com]

## Installs

- Using Precise32 Ubuntu
- Apache 2
- PHP 5.5
- MySQL 5.5 (root:<none>)
- PhalconPHP
- PhalconPHP DevTools
- Redis 2.8
- Git
- Composer (PHP)

# Installation

First clone this repository locally. Then run the following:

    $ vagrant up

The `init.sh` script will provision the system with everything needed.
To get into vagrant ssh, simply type:

    $ vagrant ssh

If you want to change your bound address, edit the Vagrantfile and do:

    $ vagrant reload

Here are a few other credentials setup by default:

    SSH: vagrant / vagrant
    Host Address: 192.168.5.0
    MySQL: root / (none)

