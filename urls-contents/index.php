<?php
  $http = new urls_http();
  $PATH = $http->get_path();

  $db = new urls_query();
  $URL = $db->fetch_longurl($PATH);

  $result = urlencode_mbonly($URL);

  if($URL !== null && headers_sent()) {
    include(dirname(__file__) . '/inc/header.php');
    echo '<p>You\'ll be redirected in about 3 secs. If not, click <a href="' . $result . '">here</a>.' . "</p>\n";
    echo '<p>' . $URL . "</p>\n";

    return 0;
  }elseif($URL !== null) {
    $http->urls_refresh('1', $result);
    include(dirname(__file__) . '/inc/header.php');
    echo '<p>You\'ll be redirected in about 1 secs. If not, click <a href="' . $result . '">here</a>.' . "</p>\n";
    echo '<p>' . $URL . "</p>\n";

    return 0;
  }
  
  session_start();
  
  $SID = session_id();
  
  if(empty($_SESSION['PHPSESSID'])){
    $_SESSION['PHPSESSID'] = $SID;
  }elseif($_SESSION['PHPSESSID'] === $SID){
    session_regenerate_id();
    $_SESSION['PHPSESSID'] = session_id();
  }else{
    echo '<p>不正なアクセスを検出しました</p>' . "\n";
    echo '<p>ページをリロードしてください</p>' . "\n";
    
    session_regenerate_id();
    $_SESSION['PHPSESSID'] = session_id();
    
    return 0;
  }
  
  $login = empty($_COOKIE['login']) ? null : $_COOKIE['login'];
  
  if($login !== null){
    setcookie('login', true, time() + 60*60*1, '/', urlsdomain);
  }else{
    setcookie('login', null, time() - 60, '/', urlsdomain);
  }
  
  $linkpath = mb_strtolower($PATH);

  if(preg_match('%\A(/api|/api/)\z%', $linkpath)) {
    include(ABSPATH . '/urls-api/api.php');
    return 0;
  }

  if(preg_match('%\A(/get-shorturl|/get-shorturl/)\z%', $linkpath)) {
    include(dirname(__file__) . '/api.php');
    return 0;
  }
  
  if(preg_match('%\A(/duplicatecheck.js|/duplicatecheck.js/)\z%', $linkpath)) {
    include(dirname(__file__) . '/inc/duplicatecheck.js.php');
    return 0;
  }

  if(preg_match('%\A(/signout|/signout/)\z%', $linkpath)) {
    setcookie('login', null, time() - 60, '/', urlsdomain);
    $http->urls_refresh('1', '/signinpage');
    return 0;
  }

  if(preg_match('%\A(|/|/index.php)\z%', $linkpath)):
    include(dirname(__file__) . '/top.php');


  elseif(preg_match('%\A(/url-shorting|/url-shorting/)\z%', $linkpath)):
    include(dirname(__file__) . '/urlshorting.php');

  elseif(preg_match('%\A(/userpage|/userpage/)\z%', $linkpath)):
    include(dirname(__file__) . '/userpage.php');

  elseif(preg_match('%\A(/signinpage|/signinpage/)\z%', $linkpath)):
    include(dirname(__file__) . '/signinpage.php');

  elseif(preg_match('%\A(/register|/register/)\z%', $linkpath)):
    include(dirname(__file__) . '/register.php');

  elseif(preg_match('%\A(/get-apikey|/get-apikey/)\z%', $linkpath)):
    include(dirname(__file__) . '/userapikey.php');

  elseif(preg_match('%\A(/duplicatechecker|/duplicatechecker/)\z%', $linkpath)):
    include(dirname(__file__) . '/duplicatecheck.php');

  else:
    include(dirname(__file__) . '/404.php');

  endif;

  if(defined('TIME_PUSH') && TIME_PUSH) {
    $end = microtime(true);

    echo '<p>ViewTime: ' . sprintf('%0.5f', $end - $start) . "sec</p>\n";
  }

  return 0;
