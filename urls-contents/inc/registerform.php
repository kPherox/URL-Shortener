<form method='post' action='/register'>
  <ul class='form'>
    <li><label>Username: <input name='username' value='<?php echo($username); ?>'></label></li>
    <li><label>Password: <input type='password' name='password'value='<?php echo($password); ?>'></label></li>
    <li><label>E-mail: <?php echo($email); ?><input name='email' value='<?php echo($email); ?>' hidden></label></li>
    <input type='hidden' name='register' value='register'>
    <input type='hidden' name='token' value='<?php echo($token); ?>'>
    <input type='reset' value='Reset'>
    <input type='submit' value='Register'>
  </ul>
</form>
