<?php
  // Use PHPMailer when send Regist Mail
  // [ true / false ]
  //define('USE_PHPMAILER', false);
  
  // Use Native cron for URL Shortener's CRON
  // [ true / false ]
  define('DISABLE_URLS_CRON' . true);
  
  // View Script Run Time
  // [ true / false ]
  //define('TIME_PUSH',     false);

  // Use Debug Mode
  // [ true / false ]
  //define('DEBUG_MODE',    false);

  require(dirname(__file__) . '/urls-settings.php');
