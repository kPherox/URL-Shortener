<?php
  class urls_http {
    public function get_url() {
      $requrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
      $URL = scheme . '://' . urlsdomain . $requrl;
      return $URL;
    }

    public function get_path() {
      $PATH = parse_url($this->get_url(), PHP_URL_PATH);
      return $PATH;
    }

    public function urls_refresh($reftime = '1', $url = null) {
      $url = empty($url) ? $this->get_url() : $url;
      $ua = $_SERVER['HTTP_USER_AGENT'];
      if(strpos($ua,'iPhone') || strpos($ua,'iPod') || strpos($ua,'iPad')) {
        $browser = 'ios';
      }
      if($browser === 'ios'){
        header('refresh:' . $reftime . ';url=' . $url);
      }else{
        header('Location: ' . $url);
      }
    }
  
    function reset_session() {
      $_SESSION['username'] = null;
      setcookie('login', null, time() - 60, '/', urlsdomain);
      $this->urls_refresh('1', '/signinpage');
    }
  }
