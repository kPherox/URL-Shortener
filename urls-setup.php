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
