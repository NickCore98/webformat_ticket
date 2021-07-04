<?php
  include_once(__DIR__.'/../../db/db.php');
  // CLASS BASE WITH MOST COMMON METHODS
  class BaseModel {
    // variables
    public $ID;
    protected $myDB;

    // function to connect with DB
    public function connect_db(){
      $this->myDB = new MyDB();
      $this->myDB->open_connection();
    }

    // function to close connection with DB
    public function disconnect_db(){
      $this->myDB->close_connection();
    }

    // function to get info from given query
    public function get_by_query($sql){
      $this->connect_db();
      $res = $this->myDB->exec_select_query($sql);
      $this->disconnect_db();
      return $res;
    }

    // function to delete object form given DB table
    public function delete_from($table){
      if ( $this->ID != NULL){
        $this->connect_db();
        $sql = "DELETE FROM ".$table." WHERE ID=".$this->ID.";";
        $this->myDB->exec_sql_statement($sql);
        $this->disconnect_db();
      }
    }

  }

?>
