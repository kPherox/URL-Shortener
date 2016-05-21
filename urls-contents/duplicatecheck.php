<?php
  $dupcheck = empty($_POST['check']) ? null : $_POST['check'];
  $strcheck = empty($_POST['str']) ? null : mb_strtolower($_POST['str']);

  if((defined('USER_DUPLICATE') && USER_DUPLICATE) || ($dupcheck === 'username')) {
    if(defined('USER_DUPLICATE')) {runkit_constant_remove('USER_DUPLICATE');}
    if(defined('DUPLICATE_USER')) {runkit_constant_remove('DUPLICATE_USER');}

    $strcheck = empty($username) ? $strcheck : mb_strtolower($username);

    if($strcheck !== null) {
      $result = $db->check_duplicate_username($strcheck);

      if($result > 0) {
        define('DUPLICATE_USER', true);
      }else{
        define('DUPLICATE_USER', false);
      }
    }else{
      define('DUPLICATE_USER', true);
    }


    if(empty($dupcheck)) {
      return 0;
    }else{
      var_dump(DUPLICATE_USER);
      return 0;
    }
  }

  if((defined('API_DUPLICATE') && API_DUPLICATE) || ($dupcheck === 'api')) {
    if(defined('API_DUPLICATE')) {runkit_constant_remove('API_DUPLICATE');}
    if(defined('DUPLICATE_API')) {runkit_constant_remove('DUPLICATE_API');}

    $strcheck = empty($apiuid) ? $strcheck : mb_strtolower($apiuid);

    if($strcheck !== null) {
      $result = $db->check_duplicate_api($strcheck);

      if($result['num_rows'] > 0) {
        define('DUPLICATE_API', true);
      }else{
        define('DUPLICATE_API', false);
      }
    }else{
      define('DUPLICATE_API', true);
    }

    if(empty($dupcheck)) {
      return 0;
    }else{
      var_dump(DUPLICATE_API);
      return 0;
    }
  }

  if((defined('LONG_DUPLICATE') && LONG_DUPLICATE) || ($dupcheck === 'longurl')) {
    if(defined('LONG_DUPLICATE')) {runkit_constant_remove('LONG_DUPLICATE');}
    if(defined('DUPLICATE_LONG')) {runkit_constant_remove('DUPLICATE_LONG');}
    if(defined('DUPLICATED_SHORT')) {runkit_constant_remove('DUPLICATED_SHORT');}

    $strcheck = empty($longurl) ? $strcheck : mb_strtolower($longurl);

    if($strcheck !== null) {
      $result = $db->check_duplicate_longurl($strcheck);

      if($result['num_rows'] > 0) {
        define('DUPLICATE_LONG', true);
      }else{
        define('DUPLICATE_LONG', false);
      }

      if(DUPLICATE_LONG) {
        $colm = $result['column'];
        define('DUPLICATED_SHORT', $colm['short_url']);
      }
    }else{
      define('DUPLICATE_LONG', true);
      define('DUPLICATED_SHORT', true);
    }

    if(empty($dupcheck)) {
      return 0;
    }else{
      var_dump(DUPLICATE_LONG);
      return 0;
    }
  }

  if((defined('SHORT_DUPLICATE') && SHORT_DUPLICATE) || ($dupcheck === 'shorturl')) {
    if(defined('SHORT_DUPLICATE')) {runkit_constant_remove('SHORT_DUPLICATE');}
    if(defined('DUPLICATE_SHORT')) {runkit_constant_remove('DUPLICATE_SHORT');}

    $strcheck = empty($shorturl) ? $strcheck : mb_strtolower($shorturl);

    if($strcheck !== null) {
      $result = $db->check_duplicate_shorturl($strcheck);

      if($result['num_rows'] > 0) {
        define('DUPLICATE_SHORT', true);
      }else{
        define('DUPLICATE_SHORT', false);
      }
    }else{
      define('DUPLICATE_SHORT', true);
    }

    if(empty($dupcheck)) {
      return 0;
    }else{
      var_dump(DUPLICATE_SHORT);
      return 0;
    }
  }

  if((defined('MAIL_DUPLICATE') && MAIL_DUPLICATE) || ($dupcheck === 'mail')) {
    if(defined('MAIL_DUPLICATE')) {runkit_constant_remove('MAIL_DUPLICATE');}
    if(defined('DUPLICATE_MAIL')) {runkit_constant_remove('DUPLICATE_MAIL');}
    if(defined('DUPLICATE_TOKEN')) {runkit_constant_remove('DUPLICATE_TOKEN');}

    $strcheck = empty($email) ? $strcheck : mb_strtolower($email);

    if($strcheck !== null) {
      $result = $db->check_duplicate_mail($strcheck);

      if($result['first'] > 0) {
        define('DUPLICATE_MAIL', true);
      }else{
        define('DUPLICATE_MAIL', false);
      }

      if($result['second'] > 0) {
        define('DUPLICATE_TOKEN', true);
      }else{
        define('DUPLICATE_TOKEN', false);
      }
    }else{
      define('DUPLICATE_MAIL', true);
      define('DUPLICATE_TOKEN', true);
    }

    if(empty($dupcheck)) {
      return 0;
    }else{
      var_dump(DUPLICATE_MAIL);
      return 0;
    }
  }

  if($dupcheck !== null) {
    echo 'Not Found Duplicater';
    return 0;
  }
