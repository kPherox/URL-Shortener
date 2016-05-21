<?php
  $query = '?url=$URL&short=$SHORT&uid=$apiuid&key=$apikey&title=$TITLE&format=$FORMAT';
  $url = scheme . '://' . urlsdomain . '/api';
  $urlscheme = $url . $query;
  include(dirname(__file__) . '/inc/header.php');
  
  include(dirname(__file__) . '/inc/shortingform.php');
  
  include(dirname(__file__) . '/inc/howto.php');
  
  include(dirname(__file__) . '/inc/footer.php');
  