<?php
  require_once(dirname(__file__) . '/urls-config.php');
  require(dirname(__file__) . '/urls-lib/core.php');
  
  $now = date('Y-m-d H:m:s');

  $db = new urls_query();
  
  $shortenstatus = $db->get_user_shortenurl();
  $shorturls = $shortenstatus['rows'];
  $shortendatas = $shortenstatus['data'];

  foreach(range(0, $shorturls - 1) as $rownum) {
    $shortendata = $shortendatas[$rownum];

    $lid = $shortendata['link_id'];
    $createdate = $shortendata['create_date'];
    $daysago = (strtotime($now) - strtotime($createdate)) / (60*60*24);

    if($daysago > 14) {
      echo $daysago . "\n";
      $result = $db->delete_shorturl($lid);
    }
  }
  
  $tokenstatus = $db->get_token();
  $tokens = $tokenstatus['rows'];
  $tokendatas = $tokenstatus['data'];
  
  if($tokens > 0) {
    foreach(range(0, $tokens - 1) as $rownum) {
      $tokendata = $tokendatas[$rownum];

      $token = $tokendata['token'];
      $createdate = $tokendata['create_date'];
      $daysago = (strtotime($now) - strtotime($createdate)) / (60*60);

      if($daysago > 24) {
        echo $daysago . "\n";
        $result = $db->remove_token($token);
      }
    }
  }

  $db->close();
