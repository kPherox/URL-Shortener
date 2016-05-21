<?php
  class urls_mysql extends mysqli {
    public function __construct() {
      parent::init();
      
      if(!parent::options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 1')) {
        die('Setting MYSQLI_INIT_COMMAND failed');
      }
      
      if(!parent::options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
        die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
      }
      
      parent::ssl_set(null, null, null, null, null);
      
      if(!parent::real_connect(dbhost, dbuser, dbpasswd, dbname, null, null, MYSQLI_CLIENT_COMPRESS && MYSQLI_CLIENT_SSL)) {
        die('Connect Error ( ' . mysqli_connect_errno() . ' ) ' . mysqli_connect_error());
      }
      
      if(!parent::set_charset(dbcharset)) {
        printf("Error loading character set " . dbcharset . ": %s\n", $mysqli->error);
      }
    }
  }
  