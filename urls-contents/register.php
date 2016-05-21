<?php
  $token = empty($_GET['token']) ? null : $_GET['token'];
  $token = empty($_POST['token']) ? $token : $_POST['token'];
  $register = empty($_POST['register']) ? null : $_POST['register'];
  $email = empty($_POST['email']) ? null : $_POST['email'];
  $username = empty($_POST['username']) ? null : $_POST['username'];
  $password = empty($_POST['password']) ? null : $_POST['password'];

  include(dirname(__file__) . '/inc/header.php');

  if($register === 'register') {
    if(empty($email)) {
      echo "<p>メールアドレスの確認ができません。最初からやり直してください</p>\n";
      return 0;
    }

    if(empty($username) || empty($password)) {
      echo "<p>Not Fill Username or Password.</p>\n";
      include(dirname(__file__) . '/inc/registerform.php');
      include(dirname(__file__) . '/inc/footer.php');
      return 0;
    }

    define('USER_DUPLICATE', true);
    include(dirname(__file__) . '/duplicatecheck.php');

    if(DUPLICATE_USER) {
      echo "<p>Duplicate Username.</p>\n";
      include(dirname(__file__) . '/inc/registerform.php');
    }else{
      $db->add_user($username, $password, $email);
      $db->remove_token($token);
      echo '<p>登録が完了しました<br />' . "\n" . '<a href="/signinpage">こちら</a>からログインできます</p>' . "\n";
    }

    include(dirname(__file__) . '/inc/footer.php');

    return 0;
  }

  if($email !== null) {
    $returncheck = $db->check_duplicate_mail($email);

    define('MAIL_DUPLICATE', true);
    include(dirname(__file__) . '/duplicatecheck.php');

    if(DUPLICATE_MAIL) {
      echo '<p>Duplicate ' . $email . "</p>\n";
      echo "<p>Retry more E-Mail Address to <a href='/register'>here</a></p>\n";

      include(dirname(__file__) . '/inc/footer.php');

      return 0;
    }

    //send mail or token push
    $rand = new urls_rand_plean();
    $randstr = $rand->get_randstr(32);

    if(DUPLICATE_TOKEN) {
      $db->update_token($email, $randstr);
    }else{
      $db->insert_token($email, $randstr);
    }

    $link = scheme . '://' . urlsdomain . '/register?token=' . $randstr;

    $from = mb_encode_mimeheader('URL Shortener (' . urlsdomain . ')');
    $reply = mb_encode_mimeheader('URL Shortener Infomation (' . urlsdomain . ')');
    $bcc = mb_encode_mimeheader('URL Shortener Admin (' . urlsdomain . ')');
    $subject = 'Register Link for URL Shortener (' . urlsdomain . ')';
    $html_message = '<!doctype html>
<html>
  <head>
    <title>Register Link for URL Shortener (' . urlsdomain . ')</title>
  </head>
  <body>
    <p>Hi, ' . $email . '</p>
    <p>Registing to click this Link</p>
    <p><a href="' . $link . '">' . $link . '</a></p>
  </body>
</html>';
    $text_message = 'Hi, ' . $email . "\r\n" . 'Registing to click this Link' . "\r\n" . $link . "\r\n";

    if(defined('USE_PHPMAILER') && USE_PHPMAILER) {

      $mail = new PHPMailer();

      $mail->isSMTP();
      $mail->SMTPAuth = SMTP_AUTH;
      $mail->Host = SMTP_HOST;
      $mail->Username = SMTP_USERNAME;
      $mail->Password = SMTP_PASSWORD;
      $mail->SMTPSecure = 'tls';
      $mail->Port = SMTP_PORT;

      $mail->From = registemail;
      $mail->FromName = $from;

      $mail->addReplyTo(infoemail);

      //$mail->addCC('');
      $mail->addBCC(adminemail);

      $mail->addAddress($email);
      $mail->Subject = $subject;

      //$mail->addAttachment('');

      $mail->isHTML(true);
      $mail->Body = $html_message;
      $mail->AltBody = $text_message;
      $mail->WordWrap = 50;

      if(!$mail->send()) {
        echo '<p>Message could not be sent</p>' . "\n";
        echo '<p>Mailer Error: ' . $mail->ErrorInfo . "\n";
        return 0;
      }else {
        echo '<p>Message has been sent</p>' . "\n";
        return 0;
      }
    }else{
      $headers = 'From: ' . $from . '<' . registemail . '>';
      $headers .= "\r\n";
      $headers .= 'Reply-To: ' . $reply . '<' . infoemail . '>';
      $headers .= "\r\n";
      $headers .= 'Bcc: ' . $bcc . '<' . adminemail . '>';
      $headers .= "\r\n";
      $headers .= 'Content-type: text/html; charset=utf-8';
      $headers .= "\r\n";

      if(!mail($email, $subject, $html_message, $headers)) {
        echo '<p>Message could not be sent</p>' . "\n";
        return 0;
      }else{
        echo '<p>Message has been sent</p>' . "\n";
        return 0;
      }
    }
  }

  if(empty($token)) {
    echo <<<EOD
<form method='post' action='/register'>
  <ul class='form'>
    <li><label>E-mail: <input id='emailform' name='email' placeholder='mail@example.com'></label><span id='emaildupcheck'>Check Duplicate</span></li>
    <input type='submit' value='Submit'>
  </ul>
</form>
EOD;
    include(dirname(__file__) . '/inc/footer.php');
    return 0;
  }

  $registoken = $db->search_token($token);

  if($registoken['status'] === false || $registoken['email'] === null) {
    echo "<p>無効なURLか期限切れです</p>\n";
    echo "<p><a href='/register'>こちら</a>でメールアドレスを登録してください</p>\n";
    include(dirname(__file__) . '/inc/footer.php');
    return 0;
  }

  $email = $registoken['email'];

  include(dirname(__file__) . '/inc/registerform.php');
  include(dirname(__file__) . '/inc/footer.php');
