<?php
  if(defined('DISABLE_URLS_CRON') && DISABLE_URLS_CRON) {
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
    
    return 0;
  }else{
    require_once(ABSPATH . '/urls-cron.php');
  }
  
