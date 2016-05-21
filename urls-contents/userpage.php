<?php
  if(empty($_SESSION['username'])){
    $http->reset_session();
    return 0;
  }else{
    $username = $_SESSION['username'];
  }
  
  if($login === null){
    $http->reset_session();
    return 0;
  }
  
  $hashpass = $db->login_user($username);
  
  if($hashpass !== $_SESSION['hashpass']){
    $http->reset_session();
    return 0;
  }
  
  include(dirname(__file__) . '/inc/header.php');
  
  $userstatus = $db->get_user_status($db->get_user_uid($username));
  
  $userid = $userstatus['user_id'];
  $userapiuid = $userstatus['api_uid'];
  $userapikey = $userstatus['api_key'];
  $useremail = $userstatus['email_address'];
  
  echo '<p>Hi, ' . $username . ".</p>\n";
  
  echo "<article>\n";
  if(empty($userapiuid) || empty($userapikey)): ?>
<p>You Don't Have API Status.</p>
<p>Click to this Button when Get API Key.</p>
<form method='post' action='/get-apikey'>
  <input type='hidden' name='uid' value='<?php echo($userid); ?>'>
  <input type='submit' value='Get API Key'>
</form>

<?php else: ?>
<p>Your API's User ID & API Key</p>
<pre>API's User ID
<?php echo($userapiuid); ?>
</pre>
<pre>
API Key
<?php echo($userapikey); ?>
</pre>
<form method='post' action='/get-apikey'>
  <input type='hidden' name='uid' value='{$userid}'>
  <input type='submit' value='Refresh API Key'>
</form>
<?php endif;
  echo "</article>\n";
  
  $shortenstatus = $db->get_user_shortenurl($username);
  
  if($shortenstatus['rows'] === 0):
    echo "<p>Not Create ShortURLs</p>\n";
    
  else:
    $shorturls = $shortenstatus['rows'];
    $shortendatas = $shortenstatus['data'];
    
    $now = date('Y-m-d');
    
    foreach(range(0, $shorturls - 1) as $rownum) {
      $shortendata = $shortendatas[$rownum];
      
      $linktitle = $shortendata['link_title'];
      $longurl = $shortendata['long_url'];
      $longurl = urlencode_mbonly($longurl);
      $shorturl = scheme . '://' . urlsdomain . $shortendata['short_url'];
      $createdate = $shortendata['create_date'];
      $day = date('Y-m-d', strtotime($createdate));
      $daysago = (strtotime($now) - strtotime($day)) / (60*60*24);
      
      $linkname = $linktitle === $longurl ? '<a href="' . $longurl . '">' . mb_strimwidth($linktitle, 0, 64, "...") . '</a>' : $linktitle . '</li><li><a href="' . $longurl . '">' . mb_strimwidth($longurl, 0, 64, "...") . '</a>';
?>
<article>
  <ul>
<?php
      echo '<li>' . $linkname . "</li>\n";
      echo '<li>' . $shorturl . "</li>\n";
      echo '<li>' . $createdate . ' / ' . $daysago . "days ago</li>\n";
?>
  </ul>
</article>
<?php
    }
    
  endif;
  