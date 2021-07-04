<?php
  include_once('base_model.php');
  include_once('task.php');
  include_once('employee.php');

  // CLASS ASSIGNMENT
  class Assignment extends BaseModel {
    public $task;
    public $DEV;

    // init function
    public function __construct(int $task=NULL, int $DEV=NULL){
      $this->task = $task;
      $this->DEV = $DEV;
    }

    // function to create object from DB ID
    public function get_by_ID(int $ID) {
      $sql = "SELECT * FROM assignment WHERE ID=".$ID.";";
      return $this->get_by_myquery($sql);
    }

    // function to create object from DB task and DEV IDs
    public function get_by_task_DEV(int $task, int $DEV) {
      $sql = "SELECT * FROM assignment WHERE Task=".$task." and DEV=".$DEV.";";
      return $this->get_by_myquery($sql);
    }

    // function to create object from given query
    private function get_by_myquery($sql){
      $res = $this->get_by_query($sql);
      $this->ID = $res[0]['ID'];
      $this->task = $res[0]['Task'];
      $this->DEV = $res[0]['DEV'];
      return $this;
    }

    // function to save object in DB (Insert if new or Update if alredy exists)
    public function save(){
      $this->connect_db();
      if ( $this->ID != NULL){
        $sql = "UPDATE assignment SET
          Task='".$this->task."',
          DEV='".$this->DEV."' WHERE ID=".$this->ID.";";
      } else {
        $sql = "INSERT INTO assignment (Task, DEV)
          VALUES
            ('".$this->task."',
             '".$this->DEV."'
           )";
      }
      $this->myDB->exec_sql_statement($sql);
      $this->disconnect_db();
      return $this;
    }

    // function to delete db row
    public function delete(){
      $this->delete_from('assignment');
    }

    // function to get Task Object
    public function get_task(){
      if ( $this->task != NULL){
        $myTask  = new Task ();
        return $myTask->get_by_ID($this->task);
      }

    }

    // function to get Employee Object
    public function get_DEV(){
      if ( $this->DEV != NULL){
        $myDEV = new Employee();
        return $myDEV->get_by_ID($this->DEV);
      }
    }

  }


?>
