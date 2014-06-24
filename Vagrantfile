#!/usr/bin/env ruby
# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  # Base Box
  # --------------------
  config.vm.box = "wheezy64nocm"
  config.vm.box_url = "http://puppet-vagrant-boxes.puppetlabs.com/debian-73-x64-virtualbox-nocm.box"

  # Connect to IP
  # --------------------
  config.vm.network :private_network, ip: "192.168.5.100"

  # Forward to Port
  # --------------------
  #config.vm.network :forwarded_port, guest: 80, host: 8080

  # Optional (Remove if desired)
  config.vm.provider :virtualbox do |v|
    # How much RAM to give the VM (in MB)
    # -----------------------------------
    v.customize ["modifyvm", :id, "--memory", "512"]
    v.name = "img-service"

    # Uncomment the Bottom two lines to enable muli-core in the VM
    #v.customize ["modifyvm", :id, "--cpus", "2"]
    #v.customize ["modifyvm", :id, "--ioapic", "on"]
  end

  config.hostsupdater.remove_on_suspend = true
  config.vm.hostname = "img.h4md1.dev"
  config.hostsupdater.aliases = ["img0.h4md1.dev"]

  # Provisioning Script
  # --------------------
  #config.vm.provision "shell", path: "provision/init.sh"

  config.vm.provision "ansible" do |ansible|
    ansible.limit= "all"
    ansible.playbook = "provision/playbook.yml"
  end


  # Synced Folder
  # --------------------
  # config.vm.synced_folder ".", "/vagrant/", :mount_options => [ "dmode=777", "fmode=666" ]
  config.vm.synced_folder "./application", "/var/www/img/", :mount_options => [ "dmode=775", "fmode=644" ], :owner => 'www-data', :group => 'www-data'

end
