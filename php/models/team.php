<?php
  include_once('base_model.php');
  include_once('employee.php');

  // CLASS TEAM
  class Team extends BaseModel {
    // variable
    public $name;

    // init function
    public function __construct(string $name=NULL){
      $this->name = $name;
    }

    // function to get Object from ID
    public function get_by_ID(int $ID) {
      $sql = "SELECT * FROM team WHERE ID=".$ID;
      return $this->get_by_myquery($sql);
    }

    // function to get Object from title
    public function get_by_title(string $title) {
      $sql = "SELECT * FROM team WHERE Name='".$title."'";
      return $this->get_by_myquery($sql);
    }

    // function to get Object from query
    private function get_by_myquery($sql){
      $res = $this->get_by_query($sql);
      $this->ID = $res[0]['ID'];
      $this->name = $res[0]['Name'];
      return $this;
    }

    // function to save object in DB (Insert if new or Update if alredy exists)
    public function save(){
      $this->connect_db();
      if ( $this->ID != NULL){
        $sql = "UPDATE team SET
          Name='".$this->name."'
          WHERE ID=".$this->ID.";";
      } else {
        $sql = "INSERT INTO team (Name)
          VALUES ('".$this->name."')";
      }
      $this->myDB->exec_sql_statement($sql);
      $this->disconnect_db();
    }

    // functio to delete DB row
    public function delete(){
      $this->delete_from('team');
    }


    // function to get all Employee members of the Team
    public function get_all_members(){
      if ( $this->ID != NULL){
        $sql = "SELECT ID FROM employee where Team=".$this->ID ;
        $employeeIDs = $this->get_by_query($sql);
        $members = array();
        foreach ($employeeIDs as &$eID){
          $myEmployee = new Employee();
          $myEmployee = $myEmployee->get_by_ID($eID['ID']);
          array_push($members, $myEmployee);
        }
        return $members;
      }
    }

    // function to get the Employee Objects that has Role 'PM'
    public function get_team_PM(){
      if ( $this->ID != NULL){
        $members = $this->get_all_members();
        $rolePM = new Role();
        $rolePM = $rolePM->get_by_title('PM');
        foreach ($members as &$myEmployee){
          if($myEmployee->role == $rolePM->ID){
            return $myEmployee;
          }
        }
      }
    }

  }

?>
