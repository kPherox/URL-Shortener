<?php
  /** * * * * * * * * * * * * * * * * * * * * * * * ***
   *  == == == == == == How to Use == == == == == == *
   * Add to index.php This                           *
   * define('USE_PHPMAILER', true);                  *
   *                                                 *
   * #PHPMailer                                      *
   * https://github.com/phpmailer/phpmailer          *
   *                                                 *
   * ##Move to URL Shortener Directory               *
   * =================================               *
   * URL Shortener Directory                         *
   *  |=> **phpmailer/**                             *
   *  |=> urls-api/                                  *
   *  |=> urls-contents/                             *
   *  |=> urls-lib/                                  *
   *  |=> index.php                                  *
   * =================================               *
   *                                                 *
  *** * * * * * * * * * * * * * * * * * * * * * * * **/
  // SMTP Server Host
  // [ '%host server%' ]
  define('SMTP_AUTH',     true);
  
  // SMTP Server Host
  // [ '%host server%' ]
  define('SMTP_HOST',     'smtp.example.com');

  // SMTP Server Username
  // [ '%username%' ]
  define('SMTP_USERNAME', registemail);
  
  // SMTP Server Password
  // [ '%password%' ]
  define('SMTP_PASSWORD', '%password%');
  
  // SMTP Server Port
  // [ '%password%' ]
  define('SMTP_PORT',     587);
  