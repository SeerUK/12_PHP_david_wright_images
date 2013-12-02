#
# Apache 2 Module
# ---------------

require basic


# Apache 2

class apache2 {

  class { "apache":
    default_vhost => false,
    mpm_module    => "prefork"
  }

  apache::mod { "php5": }
  apache::mod { "rewrite": }

  apache::vhost { "misa.dev":
    port          => "80",
    docroot       => "/opt/DWI/src/web",
    docroot_owner => "vagrant",
    docroot_group => "vagrant",
    override      => "All",
  }

}

