#!/usr/bin/env ruby
# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.network :private_network, ip: "192.168.5.100"

  config.vm.provider :virtualbox do |v|
    v.customize ["modifyvm", :id, "--memory", "512"]
    v.name = "imgservice"
  end
  
  config.vm.define "imgservice" do |imgservice|
  end

  config.hostsupdater.remove_on_suspend = true
  config.vm.hostname = "img.h4md1.dev"
  config.hostsupdater.aliases = ["img0.h4md1.dev"]

  config.vm.provision "ansible" do |ansible|
    ansible.limit= "all"
    ansible.playbook = "provision/playbook.yml"
  end

  config.vm.synced_folder "./application", "/var/www/img/", :mount_options => [ "dmode=775", "fmode=646" ], :owner => 'www-data', :group => 'www-data'

end
