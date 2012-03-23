<?php
  class Connection{

    private $db;

    private $server;
    private $user;
    private $password;
    private $db_name;

    private $defaults = array(
      'server' => 'localhost',
      'user' => 'root',
      'password' => 'yaraher2',
      'db_name' => 'boulevard_production'
    );

    function Connection(){

      $args = func_get_args();

      if(count($args) == 0){
        $options = $this->defaults;
      }
      else{
        $options = $args[0];
      }

      $this->server = $options['server'].( (array_key_exists('port', $options))? ':'.$options['port'] : '' );
      $this->user = $options['user'];
      $this->password = $options['password'];
      $this->db_name = $options['db_name'];

      $this->db = mysql_connect($this->server, $this->user, $this->password);
      mysql_select_db($this->db_name, $this->db);

    }

    function find_by_sql($sql){
      $result = mysql_query($sql);

      return $result;
    }
    
  }
?>