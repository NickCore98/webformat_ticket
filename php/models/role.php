<?php
  include_once('base_model.php');

  // CLASS ROLE
  class Role extends BaseModel {
    // variables
    public $title;
    public $description;

    // init function
    public function __construct(string $title=NULL, string $description=NULL){
      $this->title = $title;
      $this->description = $description;
    }

    // function to get Object by ID
    public function get_by_ID(int $ID) {
      $sql = "SELECT * FROM role WHERE ID=".$ID;
      return $this->get_by_myquery($sql);
    }

    // function to get Object by Title
    public function get_by_title(string $title) {
      $sql = "SELECT * FROM role WHERE Title='".$title."'";
      return $this->get_by_myquery($sql);
    }

    // function to get Object by query
    private function get_by_myquery($sql){
      $res = $this->get_by_query($sql);
      $this->ID = $res[0]['ID'];
      $this->title = $res[0]['Title'];
      $this->description = $res[0]['Description'];
      return $this;
    }

    // function to save object in DB (Insert if new or Update if alredy exists)
    public function save(){
      $this->connect_db();
      if ( $this->ID != NULL){
        $sql = "UPDATE role SET
          Title='".$this->title."',
          Description='".$this->description."' WHERE ID=".$this->ID.";";
      } else {
        $sql = "INSERT INTO role (Title, Description)
          VALUES
            ('".$this->title."',
             '".$this->description."'
           )";
      }
      $this->myDB->exec_sql_statement($sql);
      $this->disconnect_db();
    }

    // function to delete Db row
    public function delete(){
      $this->delete_from('role');
    }

  }

?>
