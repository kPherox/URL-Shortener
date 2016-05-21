<?php
  $uid = empty($_POST['uid']) ? null : $_POST['uid'];
  
  if($uid !== null) {
    $randuid = new urls_rand_apiuid();
    $randkey = new urls_rand_apikey();
    $apikey = $randkey->get_randstr();
    
    do {
      $apiuid = $randuid->get_randstr();
      
      define('API_DUPLICATE', true);
      include(dirname(__file__) . '/duplicatecheck.php');
    } while(DUPLICATE_API);
    
    $db->add_user_api($uid, $apiuid, $apikey);
    
    $http->urls_refresh('1', '/userpage');
  }else{
    http_response_code(500);
    $http->urls_refresh('1', '/userpage');
  }
  