# 
# Environment Setup
# -----------------

include basic
include php54
# include php54::composer


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

# Services::Apache2

class { "apache": 
  default_mods => false,
}

apache::mod { "rewrite": }

apache::vhost { "misa.dev":
  port          => "80",
  docroot       => "/var/www/src/web",
  docroot_owner => "vagrant",
  docroot_group => "vagrant",
  override      => "All",
}

