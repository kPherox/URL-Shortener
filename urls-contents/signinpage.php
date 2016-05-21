<?php
  include(dirname(__file__) . '/inc/header.php');
  
  if($login !== null){
    $http->urls_refresh('1', '/userpage');
    return 0;
    
  }elseif(empty($_POST['username']) && empty($_POST['password'])){
    
  }elseif(empty($_POST['username']) || empty($_POST['password'])){
    $blank = empty($_POST['username']) ? 'Username' : 'Password';
    
    echo '<p>Not Fill ' . $blank . "</p>\n";
    
  }else{
    $username = $_POST['username'];
    $passwd = $_POST['password'];
    
    $hashpass = $db->login_user($username);
    
    $result = password_verify($passwd, $hashpass);
    
    if($result){
      $hashpass = $db->reloadpass($username, $passwd);
      $_SESSION['username'] = $username;
      $_SESSION['hashpass'] = $hashpass;
      setcookie('login', true, time() + 60*60*1, '/', urlsdomain);
      $http->urls_refresh('1', '/userpage');
      echo "<p>login success! redirect to userpage!</p>\n";
      return 0;
      
    }else{
      echo "<p>field login!</p>\n";
      
    }
  
  }
  
  include(dirname(__file__) . '/inc/signinform.php');
  include(dirname(__file__) . '/inc/footer.php');
  
  return 0;
  