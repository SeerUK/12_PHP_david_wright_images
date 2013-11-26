# 
# PHP 5.4 Base Setup
# ------------------

require basic


# PHP 5.4 & Modules

class php54 {

  class { 'php':
    notify  => Service['apache2'],
  }

  php::module {[
      'cli',
      'intl',
      'memcache',
      'memcached'
    ]:
    notify => Service['apache2'],
  }

  php::module { 'apc':
    module_prefix => "php-",
    notify        => Service ['apache2'],
  }
  
}

