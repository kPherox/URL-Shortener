<?php
  if(empty($_POST['longurl'])) {
    http_response_code(500);
    return 0;
  }

  $longurl = $_POST['longurl'];
  $longurl = urldecode($longurl);

  $matchnn = 'http://http://';
  $matchns = 'http://https://';
  $matchsn = 'https://http://';
  $matchss = 'https://https://';

  if(preg_match('#^' . $matchnn . '#',$longurl) || preg_match('#^' . $matchns . '#',$longurl) || preg_match('#^' . $matchsn . '#',$longurl) || preg_match('#^' . $matchss . '#',$longurl)) {
    http_response_code(500);
    return 0;
  }

  $matchn = 'http://' . urlsdomain;
  $matchs = 'https://' . urlsdomain;

  if(preg_match('#^' . $matchn . '#',$longurl) || preg_match('#^' . $matchs . '#',$longurl)) {
    echo $longurl;
    return 0;
  }

  $type = isset($_POST['type']) ? $_POST['type'] : 'json';
  $shortname = isset($_POST['shortname']) ? $_POST['shortname'] : null;
  $apiuid = isset($_POST['apiuid']) ? $_POST['apiuid'] : 'guest';
  $apikey = isset($_POST['apikey']) ? $_POST['apikey'] : 'guest';
  $linktitle = isset($_POST['linktitle']) ? $_POST['linktitle'] : null;

  $unique = isset($shortname) ? true : false;

  $db = new urls_query();
  $api = new urls_api();
  $rand = new urls_rand_shorturl();

  if($unique === true){
    $shorturl = '/' . $shortname;
    
    define('SHORT_DUPLICATE', true);
    include(dirname(__file__) . '/duplicatecheck.php');
    
    if(DUPLICATE_SHORT) {
      http_response_code(500);
      return 0;
    }
  }else{
    do {
      $shorturl = '/' . $rand->get_randstr();

      define('SHORT_DUPLICATE', true);
      include(dirname(__file__) . '/duplicatecheck.php');
    } while(DUPLICATE_SHORT);
  }

  if($apiuid === 'guest' || $apikey === 'guest'):
    $uid = 0;
    $createuser = 'guest';

  else:
    $column = $db->search_user($apiuid, $apikey);
    $uid = empty($column['user_id']) ? 0 : $column['user_id'];
    $createuser = empty($column['username']) ? 'guest' : $column['username'];

  endif;

  if($uid !== 0):
    define('LONG_DUPLICATE', true);
    include(dirname(__file__) . '/duplicatecheck.php');

  else:
    define('DUPLICATE_LONG', false);

  endif;

  if(DUPLICATE_LONG):
    $shorturl = DUPLICATED_SHORT;

  else:
    $db->make_shorturl($longurl,$shorturl, $uid);

  endif;

  $db->close();

  $shortapi = $api->get_status($longurl, $shorturl, $linktitle, $createuser);
  
  $json = json_encode($shortapi);
  $result = stripslashes($json);
  header('Content-Type: application/json; charset=utf-8');
  echo($result);
  