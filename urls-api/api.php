<?php
  $geturl = isset($_GET['url']) ? $_GET['url'] : null;
  $getshort = isset($_GET['short']) ? $_GET['short'] : null;
  $getuid = isset($_GET['uid']) ? $_GET['uid'] : null;
  $getkey = isset($_GET['key']) ? $_GET['key'] : null;
  $gettitle = isset($_GET['title']) ? $_GET['title'] : null;
  
  $url = isset($_POST['url']) ? $_POST['url'] : $geturl;
  $short = isset($_POST['short']) ? $_POST['short'] : $getshort;
  $uid = isset($_POST['uid']) ? $_POST['uid'] : $getuid;
  $key = isset($_POST['key']) ? $_POST['key'] : $getkey;
  $title = isset($_POST['title']) ? $_POST['title'] : $gettitle;
  
  $param = array(
    'longurl'   => $url,
    'shortname' => $short,
    'apiuid'    => $uid,
    'apikey'    => $key,
    'linktitle' => $title
    );
  
  $apiresponse = get_shorturl($param);
  
  $httpstatus = $apiresponse['status'];
  $contents = $apiresponse['contents'];
  
  if(strpos($httpstatus[0], '200')) {
    $gettype = isset($_GET['type']) ? $_GET['type'] : 'json';
    $type = isset($_POST['type']) ? $_POST['type'] : $gettype;
  $getformat = isset($_GET['format']) ? $_GET['format'] : null;
  $format = isset($_POST['format']) ? $_POST['format'] : $getformat;
    
    $api = new urls_api();
    
    if($format === 'url') {
      $type = 'txt';
    }else{
      $contents = $api->formatting($format, $contents);
    }
    
    if($type === 'json' || $type === 'xml' || $type === 'txt') {
      $method = 'return_' . $type;
      $api->$method($contents);
      return 0;
    }else{
      echo $contents;
      return 0;
    }
    
  }else{
    echo "Don't response api";
    return 0;
  }
  