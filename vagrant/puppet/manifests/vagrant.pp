# 
# Environment Setup
# -----------------

# Init

exec { "apt-get update":
  path => "/usr/bin",
}

# Basics

package {["htop", "iotop", "screen"]: 
  ensure  => present,
  require => Exec["apt-get update"],
}


# Tools

class { "apt": }

apt::ppa { "ppa:chris-lea/node.js": }

class { "nodejs":
  require => apt::ppa["ppa:chris-lea/node.js"]
}

package {["grunt-cli", "bower"]:
  ensure   => present,
  provider => "npm",
  require  => Package["nodejs"],
}

# Services

package { "apache2":
  ensure  => present,
  require => Exec["apt-get update"],
}

service { "apache2":
  enable  => true,
  ensure  => running,
  require => Package["apache2"],
}
