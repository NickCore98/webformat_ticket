<?php
  //CLASS WITH VARIABLES AND FUNCTION TO MANAGE DB INTERACTIONS
  class MyDB {

      // Variables
      protected $servername = "localhost:9906";
      protected $db_name = "test_db";
      protected $username = "devuser";
      protected $password = "devpass";
      protected $conn;

      // Function to open connection with DB
      public function open_connection() {
          try {
              $this->conn = new PDO('mysql:host='.$this->servername.';dbname='.$this->$db_name.';charset=utf8', $this->username, $this->password);
              // set the PDO error mode to exception
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sql = "USE ".$this->db_name.";";
              $this->exec_sql_statement($sql);
          } catch(Exception $e) {
              die('Connection failed:' . $e->getMessage());
          }
      }

      // Function to close connection with DB
      public function close_connection() {
          $this->conn = NULL;
      }

      // Function to execute a sql statement like create/drop/insetti/update/delete
      public function exec_sql_statement($sql){
        try {
          if($this->conn==NULL){
            $this->open_connection();
          }
         // use exec() because no results are returned
         $this->conn->exec($sql);
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
      }

      // Function to execute a "SELECT" sql query
      public function exec_select_query($sql){
        if($this->conn==NULL){
          $this->open_connection();
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->fetchAll();
        return $result;
    }

}





?>
