<?php
  class Model{

    private $conn;
    private $attributes = array();

    private $table_name;

    private $associations = array();

    public function __construct(){
      $this->conn = new Connection();

      $this->table_name = strtolower(get_class($this))."s";
    }

    public function &__get($name){
      return $this->read_attribute($name);
    }

    public function read_attribute($name){
      $pos = strlen($name)-3;

      if(array_key_exists($name, $this->attributes)){
        return $this->attributes[$name];
      }
      elseif(array_key_exists($name."_id", $this->attributes)){
        $foreign = $name."_id";
        $class_name = ucfirst($name);
        return $class_name::find((int)$this->$foreign);
      }
      else{
        //Associations
        $class_name = ucfirst(substr($name, 0, -1));

        if(class_exists($class_name)){
          if(array_key_exists($name, $this->associations))
            return $this->associations[$name];
          else
            return $this->get_associations($name);
        }
      }

      // if(strrpos($name, '_id') == $pos){
      //   $class_name = ucfirst(substr($name, 0, $pos));

      //   return $class_name::find($this->attributes[$name]);
      // }
    }

    private function assign_attributes($data){
      foreach($data as $key => $value)
        if(is_string($key))
          $this->attributes[$key] = $value;
    }

    public static function find($id){
      $class_name = get_called_class();
      $class = new $class_name();

      if(is_int($id)){
        $sql = "SELECT * FROM $class->table_name WHERE id=$id LIMIT 1";
        $result = $class->conn->find_by_sql($sql);

        if(mysql_num_rows($result) != 1){
          return null;
        }
        else{
          $data = mysql_fetch_array($result);

          $class->assign_attributes($data);

          return $class;
        }
      }
    }

    public static function last(){
      $class_name = get_called_class();
      $class = new $class_name();

      $sql = "SELECT * FROM $class->table_name ORDER BY id DESC LIMIT 1";

      $result = $class->conn->find_by_sql($sql);

      if(mysql_num_rows($result) != 1){
        return null;
      }
      else{
        $data = mysql_fetch_array($result);

        $class->assign_attributes($data);

        return $class;
      }
    }

    public function get_associations($children_name){
      $foreign_key = strtolower(get_class($this))."_id";
      $children_class_name = ucfirst(substr($children_name, 0, -1));

      $sql = "SELECT id FROM $children_name WHERE $foreign_key=$this->id";

      $result = $this->conn->find_by_sql($sql);

      if(mysql_num_rows($result) > 0){
        $this->associations[$children_name] = array();

        while($data = mysql_fetch_array($result)){
          $children_class = $children_class_name::find((int)$data['id']);

          array_push($this->associations[$children_name], $children_class);
        }

        return $this->associations[$children_name];
      }

      return array();
    }

  }
?>