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
  <input type='hidden' name='uid' value='<?php echo($userid); ?>'>
  <input type='submit' value='Refresh API Key'>
</form>
<?php include(dirname(__file__) . '/inc/shortingform.php');
  endif;
  
  echo "</article>\n";
  
  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  
  $shortenstatus = $db->get_user_shortenurl($username);
  
  echo "<article>\n";

  if($shortenstatus['rows'] === 0):
    echo "<p>Not Create ShortURLs</p>\n";

  else:
    $shorturls = $shortenstatus['rows'];
    $shortendatas = $shortenstatus['data'];
    
    $loops = round($shorturls / 20);
    
    if($loops === 1) {
      view_shorturls($shortendatas, $shorturls);
    }else{
      foreach(range(0, $loops - 1) as $count) {
        $loopcount = $count + 1;
        
        if($page == $loopcount) {
          $loop = $shorturls < (20 * $loopcount) ? $shorturls : 20 * $loopcount;
          $start = 20 * $count;
          
          $prev = $loopcount == 1 ? '<div></div><div></div>' : '<a class="prevs" href="/userpage?page=1"><div>&lt;&lt;<br />Page 1</div></a><a class="prev" href="/userpage?page=' . ($loopcount - 1) . '"><div>&lt;<br />Page ' . ($loopcount - 1) . '</div></a>';
          $thispage = '<div class="thispage">&lt;&gt;<br />Page ' . $loopcount . '</div>';
          $next = $page == $loops ? '<div></div><div></div>' : '<a class="next" href="/userpage?page=' . ($loopcount + 1) . '"><div>&gt;<br />Page ' . ($loopcount + 1) . '</div></a><a class="nexts" href="/userpage?page=' . $loops . '"><div>&gt;&gt;<br />Page ' . $loops . '</div></a>';
          
          echo '<div class="paging">' . "\n";
          echo $prev . $thispage . $next . "\n";
          echo "</div>\n";
          
          view_shorturls($shortendatas, $loop, $start);
          
          echo '<div class="paging">' . "\n";
          echo $prev . $thispage . $next . "\n";
          echo "</div>\n";
        }
      }
    }

  endif;
  
  echo "</article>\n";
  
  function view_shorturls($datas, $loop, $start = 0) {
    $now = date('Y-m-d');
    
    foreach(range($start, $loop - 1) as $rownum) {
      $data = $datas[$rownum];
      $linkid = $data['link_id'];
      $linktitle = $data['link_title'];
      $longurl = $data['long_url'];
      $longurl = urlencode_mbonly($longurl);
      $shorturl = substr($data['short_url'] , 1 , strlen($data['short_url'])-1);
      $createdate = $data['create_date'];
      $day = date('Y-m-d', strtotime($createdate));
      $daysago = (strtotime($now) - strtotime($day)) / (60*60*24);
      $hidden = '<input type="hidden" name="lid" value="' . $linkid . '">' . "\n";
      $hideinput = $hidden . '<input type="password" name="pass" hidden><input type="password" name="pass" hidden>' . "\n";
?>
<div>
  <form method="post" action="">
    <ul>
<?php
      echo '<li><input name="linktitle" value="' . $linktitle . '"> (<a href="' . $longurl . '">' . $longurl . "</a>)</li>\n";
      echo '<li>' . scheme . '://' . urlsdomain . '/' . '<input name="shorturl" value="' . $shorturl . '"></li>' . "\n";
      echo '<li>' . $createdate . ' / ' . $daysago . "days ago</li>\n";
?>
    </ul>
<?php echo($hideinput); ?>
    <input type="submit" value='Change'>
  </form>
  <form method="post" action="">
<?php echo($hidden); ?>
    <input type="submit" value='Remove'>
  </form>
</div>
<?php
    }
  }
