# 
# PHP 5.4 Base Setup
# ------------------

require basic


# PHP 5 and Modules

class php5 {

  class { 'php':
    notify  => Service['apache2'],
  }

  php::module {[
      'cli',
      'intl',
      'memcache',
      'memcached',
      'mysql',
      'xdebug'
    ]:
    notify => Service['apache2'],
  }

  php::module { 'apc':
    module_prefix => "php-",
    notify        => Service ['apache2'],
  }

  augeas { 'set-php-ini-values':
    context => '/files/etc/php5/apache2/php.ini',
    changes => [
        'set PHP/error_reporting "E_ALL | E_STRICT"',
        'set PHP/display_errors On',
        'set PHP/display_startup_errors On',
        'set PHP/html_errors On',
        'set PHP/short_open_tag Off',
        'set Date/date.timezone Europe/London',
    ],
    require => Package['php'],
    notify  => Service['apache2'],
  }
  
}

