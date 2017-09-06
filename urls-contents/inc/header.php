<?php
  header('Content-Encoding: UTF-8', true);
  header('Content-Type: text/html; charset=UTF-8', true);
?>
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0" />
  </head>
  <body>
    <header>
      <h1><a href='/'>URL Shortener</a></h1>
      <nav>
        <ul>
<?php if(empty($login) || $login === null): ?>
          <li><a href='/register'>Sign Up</a></li>
          <li><a href='/signinpage'>Sign In</a></li>
<?php else: ?>
          <li><a href='/userpage'>My Page</a></li>
          <li><a href='/signout'>Sign Out</a></li>
<?php endif; ?>
    </header>
