<?php
  define('protocol',   $_SERVER['SERVER_PROTOCOL']);
  
  if(empty(scheme)){
    define('scheme', $_SERVER['REQUEST_SCHEME']);
  }
  
  if(empty(urlsdomain)){
    define('urlsdomain', $_SERVER['HTTP_HOST']);
  }
  