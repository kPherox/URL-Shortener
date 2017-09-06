<?php
  if(defined('DEBUG_MODE') && DEBUG_MODE) {
    ini_set("display_errors",1);
    error_reporting(E_ALL);
  }

  if(defined('TIME_PUSH') && TIME_PUSH) {
    $start = microtime(true);
  }
  
  define('ABSPATH', dirname(__file__));

  require_once(ABSPATH . '/urls-config.php');
  require_once(ABSPATH . '/urls-lib/core.php');

  if(defined('USE_PHPMAILER') && USE_PHPMAILER) {
    require_once(ABSPATH . '/urls-config-phpmailer.php');
    require_once(ABSPATH . '/PHPMailer/PHPMailerAutoload.php');
  }

  if(defined('API') && API) {
    require_once(ABSPATH . '/urls-api/api.php');
    return 0;
  }

  $db = new urls_query();
  $query = "SHOW TABLES";
  $db->real_query($query);
  $result = $db->store_result();
  $rows = $result->fetch_all();

  if(!empty($rows[1])) {
    $db->close();
    require_once(ABSPATH . '/urls-contents/index.php');
    return 0;
  }

  require_once(ABSPATH . '/urls-setup.php');
