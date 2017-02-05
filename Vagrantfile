# -*- mode: ruby -*-
# vi: set ft=ruby :

NAME = 'demo'
ADDRESS = '192.168.33.13'
MEMORY = 1024
CPUS =  1

Vagrant.configure('2') do |config|

#    config.vm.box = 'hashicorp/precise64'

    config.vm.box = 'debian8base50GB'
    config.vm.box_url = 'http://mirror1.collins.kg/vagrant/debian85/debian8base50GB.box'

    config.vm.synced_folder '.', '/vagrant', disabled: true
    config.vm.synced_folder '.', '/var/www/demo', type: 'nfs'

    config.vm.hostname = NAME

    config.vm.define NAME do |host|

        host.vm.network :private_network, ip: ADDRESS

        host.vm.provider :virtualbox do |vb|
            vb.name = NAME
            vb.memory = MEMORY
            vb.cpus = CPUS
        end

    end

    config.vm.provision 'ansible' do |ansible|
        ansible.playbook = 'ansible/playbook.yml'
    end

end
