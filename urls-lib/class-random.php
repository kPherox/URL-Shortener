<?php
  abstract class urls_random {
    public function make_randstr($length) {
      $chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
      $str = '';
      
      foreach(range(1,$length) as $count) {
        $random = mt_rand(0, 61);
        $str .= $chars[$random];
      }
      
      return $str;
    }
    
    public function make_randint($length) {
      $str = '';
      
      foreach(range(1,$length) as $count) {
        $random = mt_rand(0, 9);
        $str .= $random;
      }
     
      return $str;
    }
    
    abstract public function get_randstr($length);
  }
    
  class urls_rand_plean extends urls_random {
    public function get_randstr($length) {
      $str = $this->make_randstr($length);
      return $str;
    }
  }
    
  class urls_rand_int extends urls_random {
    public function get_randstr($length) {
      $str = $this->make_randint($length);
      return $str;
    }
  }
    
  class urls_rand_apiuid extends urls_random {
    public function get_randstr($length = 8) {
      $str = 'u_' . $this->make_randint($length);
      return $str;
    }
  }
  
  class urls_rand_apikey extends urls_random {
    public function get_randstr($length = 30) {
      $str = $this->make_randstr($length);
      return $str;
    }
  }
  
  class urls_rand_shorturl extends urls_random {
    public function get_randstr($length = 6) {
      $str = $this->make_randstr($length);
      return $str;
    }
  }
  
    /*
    $apiuid = new urls_apiuid();
    $result = $apiuid->get_randstr();
    echo $result;
    
    $apikey = new urls_apikey();
    $result = $apikey->get_randstr();
    echo $result;
    
    $shorturl = new urls_shorturl();
    $result = $shorturl->get_randstr();
    echo $result;
    */