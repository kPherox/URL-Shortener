<?php
  echo "<p>Database Setuped!</p>\n";

  if(empty($rows[1]) && !empty($rows[0])) {
    $row = $rows[0];
    $tablename = $row['0'];
    $db->droptable($tablename);
  }

  $db->createtable();

  echo "<p>Add Administate User</p>\n";

  $db->add_user(adminuser, adminpasswd, adminemail);

  $db->close();

  $cronstatus = `crontab -l`;

  if($cronstatus && preg_match('#/urls-cron.php#', $cronstatus)) {
    return 0;

  }elseif($cronstatus) {
    $cronline = $cronstatus . cronline('/usr/bin/php ' . dirname(__file__) . '/urls-cron.php', '*/10');

  }else{
    $cronline = cronline('/usr/bin/php ' . dirname(__file__) . '/urls-cron.php', '*/10');

  }

  $cron = popen('/usr/bin/crontab -', 'w');
  fputs($cron, $cronline);
  pclose($cron);
