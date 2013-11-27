#
# Basic Environment
# -----------------

class basic {

  exec { 'apt-get update':
    alias   => 'aptupdate',
    command => '/usr/bin/apt-get update',
  }

  package { 'vim':
    ensure  => present,
    require => Exec['aptupdate'],
  }

  package {["htop", "iotop", "screen"]:
    ensure  => present,
    require => Exec["apt-get update"],
  }

  class { "apt": }

  apt::ppa { "ppa:chris-lea/node.js": }

  class { "nodejs":
    require => Apt::Ppa["ppa:chris-lea/node.js"]
  }

  package {["grunt-cli", "bower"]:
    ensure   => present,
    provider => "npm",
    require  => Package["nodejs"],
  }

}

