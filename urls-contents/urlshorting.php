<?php
  if(empty($_POST['longurl'])){
    include(dirname(__file__) . '/inc/header.php');

    if(empty($_COOKIE['urlsstatus'])){
      echo '<p>Empty URL</p>';
    }elseif($_COOKIE['urlsstatus'] === '500') {
      echo '<p>Don\'t response api</p>';
    }else{
      $json = $_COOKIE['urlsstatus'];
      $status = json_decode($json, true);
      $longurl = urldecode($status['longurl']);
      $shorturl = urldecode($status['shorturl']);

      echo '<p>' . $longurl . ' => <a href="' . $shorturl . '" target="_blank">' . $shorturl . "</a></p>\n";
    }
    include(dirname(__file__) . '/inc/shortingform.php');

  }else{
    $username = empty($_SESSION['username']) ? null : $_SESSION['username'];
  
    if($username !== null && $login !== null) {
      $userstatus = $db->get_user_status($db->get_user_uid($username));
      
      $apiuid = empty($userstatus['api_uid']) ? null : $userstatus['api_uid'];
      $apikey = empty($userstatus['api_key']) ? null : $userstatus['api_key'];
    }else{
      $apiuid = null;
      $apikey = null;
    }
    
    $urlscheme = $_POST['scheme'];
    $longurl = $urlscheme . $_POST['longurl'];
    $shortname = empty($_POST['shortname']) ? null : $_POST['shortname'];
    $linktitle = empty($_POST['linktitle']) ? null : $_POST['linktitle'];

    $param = array(
      'longurl'   => $longurl,
      'shortname' => $shortname,
      'apiuid'    => $apiuid,
      'apikey'    => $apikey,
      'linktitle' => $linktitle,
      );

    $apiresponse = get_shorturl($param);
    
    $httpstatus = $apiresponse['status'];
    $contents = $apiresponse['contents'];
    $json = json_encode($contents);
    
    if(strpos($httpstatus[0], '200')) {
      setcookie('urlsstatus', $json, time() + 60*5, '/', urlsdomain);
    }else{
      setcookie('urlsstatus', '500', time() + 60*5, '/', urlsdomain);
    }

    $http->urls_refresh('1');
  }
