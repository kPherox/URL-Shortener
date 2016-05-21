<?php
  http_response_code(404);
  include(dirname(__file__) . '/inc/header.php');
?>
  <body>
<?php
  echo '<p>' . stripslashes($PATH) . "</p>\n";
  echo "<p>not found this link</p>\n";
?>
<?php
  include(dirname(__file__) . '/inc/footer.php');
  