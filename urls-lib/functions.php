<?php
  function get_shorturl($param) {
    $param = http_build_query($param, "", "&");
    $header = array(
      "User-Agent: kpherox/urlshortener",
      "Content-Type: application/x-www-form-urlencoded",
      "Content-Length: " . strlen($param)
      );
    $context = array(
      "http" => array(
        "method" => "POST",
        "header" => implode("\r\n", $header),
        "content" => $param
        )
      );
    $context = stream_context_create($context);
    $url = scheme . "://" . urlsdomain . "/get-shorturl";
    $json = file_get_contents($url, false, $context);
    $contents = json_decode($json, true);
    $status = $http_response_header;
    
    return array(
      'status' => $status,
      'contents' => $contents
      );
  }
  
  function cronline($command, $minute = '*', $hour = '*', $day = '*', $month = '*', $week = '*') {
    return(sprintf("%s  %s  %s  %s  %s  %s\n",  $minute, $hour, $day, $month, $week, $command));
  }
  
  function urlencode_mbonly($str) {
    return preg_replace_callback(
      '/[^\x21-\x7e\ ]+/',
      create_function(
        '$m',
        'return urlencode($m[0]);'
        ),
      $str
      );
  }
  