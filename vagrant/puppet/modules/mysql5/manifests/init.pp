#
# Mysql 5 Module
# ---------------

require basic
include mysql::server
include mysql::client


# Mysql 5

class mysql5 {
  class { "::mysql::server":
    root_password    => "Diablo2",
    override_options => {
      "mysqld" => { "max_connections" => "1024" }
    }
  }
}
