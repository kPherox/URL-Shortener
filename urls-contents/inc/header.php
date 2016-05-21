<?php
  header('Content-Encoding: UTF-8', true);
  header('Content-Type: text/html; charset=UTF-8', true);
?>
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <header>
      <h1><a href='/'>URL Shortener</a></h1>
      <nav>
        <ul>
<?php if($login !== null): ?>
          <li><a href='/userpage'>My Page</a></li>
          <li><a href='/signout'>Sign Out</a></li>
<?php else: ?>
          <li><a href='/register'>Sign Up</a></li>
          <li><a href='/signinpage'>Sign In</a></li>
<?php endif; ?>
    </header>
