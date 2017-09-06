<?php
  class urls_query extends urls_mysql {
    public function droptable($tablename) {
      $query = '';

      $query .= "SET foreign_key_checks = 0;";
      $query .= "DROP TABLE $tablename;";
      $query .= "SET foreign_key_checks = 1;";

      if($result = $this->multi_query($query)) {
        $i = 0;
        echo "<p>";

        do {
          $i++;

          if($this->more_results()) {
            echo '----------------' . $i;
          }
        } while($this->next_result());

        echo $i . "repeated</p>\n";
      }

      return $result;
    }

    public function createtable() {
      $query = '';

      $query .= "CREATE TABLE " . dbprefix . "users(user_id int(5) NOT NULL AUTO_INCREMENT, username varchar(50) NOT NULL, password varchar(255) NOT NULL, email_address varchar(50) NOT NULL, create_date datetime NOT NULL, api_uid varchar(20), api_key varchar(255), PRIMARY KEY(user_id));";

      $query .= "CREATE TABLE " . dbprefix . "shorturls(link_id int(7) NOT NULL AUTO_INCREMENT, link_title varchar(500), long_url varchar(500) NOT NULL, short_url varchar(50) NOT NULL, create_date datetime NOT NULL, create_user_id int(5), PRIMARY KEY(link_id));";

      $query .= "CREATE TABLE " . dbprefix . "token(email_address varchar(500), token varchar(32) NOT NULL, create_date datetime NOT NULL);";

      if($result = $this->multi_query($query)) {
        $i = 0;
        echo "<p>";

        do {
          $i++;

          if($this->more_results()) {
            echo '----------------' . $i;
          }
        } while($this->next_result());

        echo $i . "repeated</p>\n";
      }

      return $result;
    }

    public function add_user($username, $password, $emailaddr) {
      $query = '';
      $opt = ["cost" => 8];
      $password = password_hash($password, PASSWORD_DEFAULT, $opt);

      $query .= "INSERT INTO " . dbprefix . "users(username, password, email_address, create_date)";
      $query .= "VALUES ('$username', '$password', '$emailaddr', now());";

      $result = $this->real_query($query);

      return $result;
    }

    public function rm_user($username, $password, $id) {
      $query = '';

      $query .= "DELETE FROM " . dbprefix . "users WHERE user_id = '$lid' username = '$username' password = '$password';";

      $result = $this->real_query($query);

      return $result;
    }

    public function reloadpass($username, $password) {
      $query = '';
      $opt = ["cost" => 8];
      $passwd = password_hash($password, PASSWORD_DEFAULT, $opt);

      $query .= "UPDATE " . dbprefix . "users SET password = '$passwd' WHERE username = '$username';";

      $this->real_query($query);

      return $passwd;
    }

    public function login_user($username) {
      $query = '';

      $query .= "SELECT username, password FROM " . dbprefix . "users WHERE username = '$username';";

      $this->real_query($query);
      $result = $this->store_result();
      $column = $result->fetch_assoc();

      $hashedpass = isset($column['password']) ? $column['password'] : null;

      return $hashedpass;
    }

    public function get_user_uid($username) {
      $query = '';

      $query .= "SELECT user_id, username FROM " . dbprefix . "users WHERE username = '$username';";

      $this->real_query($query);
      $result = $this->store_result();

      $column = $result->fetch_assoc();

      $uid = $column['user_id'];

      return $uid;
    }

    public function get_user_shortenurl($username = 'guest') {
      $uid = $username !== 'guest' ? $this->get_user_uid($username) : '0';

      $query = '';

      $query .= "SELECT * FROM " . dbprefix . "shorturls WHERE create_user_id = '$uid';";

      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;
      $column = $result->fetch_all(MYSQL_ASSOC);

      return array('rows' => $rows, 'data' => $column);
    }

    public function get_user_status($uid) {
      $query = '';

      $query .= "SELECT * FROM " . dbprefix . "users WHERE user_id = '$uid';";

      $this->real_query($query);
      $result = $this->store_result();

      $column = $result->fetch_assoc();

      return $column;
    }

    public function search_user($apiuid, $apikey) {
      $query = '';

      $query .= "SELECT user_id, username, api_uid, api_key FROM " . dbprefix . "users WHERE api_uid = '$apiuid' && api_key = '$apikey';";

      $this->real_query($query);
      $result = $this->store_result();

      $column = $result->fetch_assoc();

      return $column;
    }

    public function add_user_api($uid, $apiuid, $apikey) {
      $query = '';

      $query .= "UPDATE " . dbprefix . "users SET api_uid = '$apiuid', api_key = '$apikey' WHERE user_id = '$uid';";

      $result = $this->real_query($query);

      return $result;
    }

    public function make_shorturl($longurl, $shorturl, $uid, $linktitle = null) {
      $query = '';

      $linktitle = isset($linktitle) ? $linktitle : $longurl;

      $query .= "INSERT INTO " . dbprefix . "shorturls(long_url, short_url, link_title, create_user_id, create_date) VALUES ('$longurl', '$shorturl', '$linktitle', '$uid', now());";

      $result = $this->real_query($query);

      return $result;
    }

    public function search_shorturl($shorturl) {
      $query = '';

      $query .= "SELECT * FROM " . dbprefix . "shorturls WHERE short_url = '$shorturl';";

      $this->real_query($query);
      $result = $this->store_result();

      $column = $result->fetch_assoc();

      return $column;
    }

    public function fetch_longurl($shorturl) {
      $shortendata = $this->search_shorturl($shorturl);
      $result = $shortendata['long_url'];

      return $result;
    }

    public function delete_shorturl($lid) {
      $query = '';

      $query .= "DELETE FROM " . dbprefix . "shorturls WHERE link_id = '$lid';";

      $result = $this->real_query($query);

      return $result;
    }
    
    public function insert_token($email, $token) {
      $query = '';

      $query .= "INSERT INTO " . dbprefix . "token(email_address, token, create_date) VALUES ('$email', '$token', now());";
      
      $result = $this->real_query($query);
      
      return $result;
    }
    
    public function update_token($email, $token) {
      $query = '';

      $query .= "UPDATE " . dbprefix . "token SET token = '$token', create_date = now() WHERE email_address = '$email';";
      
      $result = $this->real_query($query);
      
      return $result;
    }

    public function remove_token($token) {
      $query = '';

      $query .= "DELETE FROM " . dbprefix . "token WHERE token = '$token';";

      $result = $this->real_query($query);

      return $result;
    }

    public function get_token() {
      $query = '';

      $query .= "SELECT * FROM " . dbprefix . "token;";

      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;
      $column = $result->fetch_all(MYSQL_ASSOC);

      return array('rows' => $rows, 'data' => $column);
    }
    
    public function search_token($token) {
      $query = '';

      $query .= "SELECT * FROM " . dbprefix . "token WHERE token = '$token'";

      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;
      
      if($rows == 0) {
        $status = false;
        $email = null;
      }
      
      $column = $result->fetch_assoc();
      
      $time = (strtotime(date('Y-m-d H:m:s')) - strtotime($column['create_date'])) / (60*60);
      
      if($time > 24) {
        $status = false;
        $email = null;
      }else{
        $status = true;
        $email = $column['email_address'];
      }
      
      return array('status' => $status, 'email' => $email);
    }

    public function check_duplicate_mail($emailaddr) {
      $query = '';

      $query .= "SELECT email_address FROM " . dbprefix . "users WHERE email_address = '$emailaddr';";

      $this->real_query($query);
      $result = $this->store_result();
      $firrow = $result->num_rows;
      
      $result->close();
      
      $query = '';

      $query .= "SELECT email_address FROM " . dbprefix . "token WHERE email_address = '$emailaddr';";

      $this->real_query($query);
      $result = $this->store_result();
      $secrow = $result->num_rows;

      return array('first' => $firrow, 'second' => $secrow);
    }

    public function check_duplicate_username($username) {
      $query = '';

      $query .= "SELECT username FROM " . dbprefix . "users WHERE username = '$username';";
      
      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;

      return $rows;
    }

    public function check_duplicate_api($apiuid) {
      $query = '';

      $query .= "SELECT api_uid FROM " . dbprefix . "users WHERE api_uid = '$apiuid';";
      
      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;
      $column = $result->fetch_assoc();

      return array('num_rows' => $rows, 'column' => $column);
    }

    public function check_duplicate_longurl($longurl, $createuid) {
      $query = '';

      $query .= "SELECT long_url, short_url, create_user_id FROM " . dbprefix . "shorturls WHERE long_url = '$longurl' && create_user_id = '$createuid';";

      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;
      $column = $result->fetch_assoc();

      return array('num_rows' => $rows, 'column' => $column);
    }

    public function check_duplicate_shorturl($shorturl) {
      $query = '';

      $query .= "SELECT short_url FROM " . dbprefix . "shorturls WHERE short_url = '$shorturl'";

      $this->real_query($query);
      $result = $this->store_result();

      $rows = $result->num_rows;
      $column = $result->fetch_assoc();

      return array('num_rows' => $rows, 'column' => $column);
    }
  }
