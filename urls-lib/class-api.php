<?php
  class urls_api {
    public function get_status($longurl, $shorturl, $linktitle, $createuser) {
      $result = array(
        'longurl' => $longurl,
        'shorturl' => scheme . '://' . urlsdomain . $shorturl,
        'linktitle' => $linktitle,
        'createuser' => $createuser
      );
      
      return $result;
    }
    
    public function formatting($format, $resultArray, $addstatus = false) {
      if($format === 'long_and_short') {
        $result = array(
          'longurl' => $resultArray['longurl'],
          'shorturl' => $resultArray['shorturl']
        );
      }elseif($format === 'short_only') {
        $result = array(
          'shorturl' => $resultArray['shorturl']
        );
      }elseif($format === 'url') {
        $result = $resultArray['shorturl'];
      }else{
        $result = $resultArray;
      }
      
      if($addstatus) {
        $result = array(
          'status_code' => 200,
          'data' => $result
        );
      }
      
      return $result;
    }
    public function return_txt($resultArray) {
      $shorturl = $resultArray;
      $result = stripslashes($shorturl);
      header('Content-Type: text/txt; charset=utf-8');
      echo($result);
    }
    
    public function return_xml($resultArray) {
      $json = json_encode($resultArray);
      $result = stripslashes($json);
      header('Content-Type: text/xml; charset=utf-8');
      echo($result);
    }
    
    public function return_json($resultArray) {
      $json = json_encode($resultArray);
      $result = stripslashes($json);
      header('Content-Type: application/json; charset=utf-8');
      echo($result);
    }
  }
  