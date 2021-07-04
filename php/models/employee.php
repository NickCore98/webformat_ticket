<?php
  include_once('base_model.php');
  include_once('role.php');
  include_once('team.php');
  include_once('task.php');
  include_once(__DIR__.'/../interfaces/assignment_interface.php');

  // CLASS EMPLOYEE THAT IMPLEMENTS 'AssignmentsInterface' METHODS
  class Employee extends BaseModel implements AssignmentsInterface {
    // variables
    public $name;
    public $surname;
    public $role;
    public $team;

    // init function
    public function __construct(string $name=NULL, string $surname=NULL,
      int $role=NULL, int $team=NULL){
      $this->name = $name;
      $this->surname = $surname;
      $this->role = $role;
      $this->team = $team;
    }

    // function to get object by ID
    public function get_by_ID(int $ID) {
      $sql = "SELECT * FROM employee WHERE ID=".$ID;
      $res = $this->get_by_query($sql);
      $this->ID = $ID;
      $this->name = $res[0]['Name'];
      $this->surname = $res[0]['Surname'];
      $this->role = $res[0]['Role'];
      $this->team = $res[0]['Team'];
      return $this;
    }

    // function to save object in DB (Insert if new or Update if alredy exists)
    public function save(){
      $this->connect_db();
      if ($this->team == NULL){
        $myTeam = "NULL";
      } else {
        $myTeam = $this->team;
      }
      if ( $this->ID != NULL){
        $sql = "UPDATE employee SET
          Name='".$this->name."',
          Surname='".$this->surname."',
          Role=".$this->role.",
          Team=".$myTeam." WHERE ID=".$this->ID.";";
      } else {
        $sql = "INSERT INTO employee (Name, Surname, Role, Team)
          VALUES
            ('".$this->name."',
             '".$this->surname."',
             ".$this->role.",
             ".$myTeam."
           )";
      }
      $this->myDB->exec_sql_statement($sql);
      // if new retrive ID
      if ( $this->ID == NULL){
        $sql = "SELECT ID FROM employee WHERE Name='".$this->name."' and
          Surname='".$this->surname."' and  Role=".$this->role." and Team";
        if ($myTeam == "NULL"){
            $sql = $sql." IS NULL";
        } else {
          $sql = $sql."=".$myTeam;
        }
        $res = $this->get_by_query($sql);
        $this->ID = $res[0]['ID'];
      }
      $this->disconnect_db();
      return $this;
    }

    // function to delete db row
    public function delete(){
      $this->delete_from('employee');
    }

    // function to get Role Object
    public function get_role(){
      if ( $this->role != NULL){
        $myRole = new Role();
        return $myRole->get_by_ID($this->role);
      }
    }

    // function to get Team Object
    public function get_team(){
      if ( $this->team != NULL){
        $myTeam = new Team();
        return $myTeam->get_by_ID($this->team);
      }
    }

    // implements interface method 'assign' creating assignment with Task Object given
    public function assign($objToAssign){
      if($this->ID != NULL and
         $objToAssign instanceof Task and
         $objToAssign->ID != NULL){
        $myAssignment = new Assignment($objToAssign->ID, $this->ID);
        return $myAssignment->save();
      }
    }

    // implements interface method 'remove_assignment' removing existing assignment with Task Object given
    public function remove_assignment($objToAssign){
      if($this->ID != NULL and
        $objToAssign instanceof Task and
        $objToAssign->ID != NULL){
        $myAssignment = new Assignment();
        $myAssignment = $myAssignment->get_by_task_DEV($objToAssign->ID, $this->ID);
        $myAssignment->delete();
        return $myAssignment;
      }
    }

    // function to find List of Task assigned
    public function get_tasks(){
      if($this->ID != NULL){
        $sql = "SELECT Task FROM assignment WHERE DEV=".$this->ID.";";
        $myTaskIDs = $this->get_by_query($sql);
        $myTaskList = array();
        foreach ($myTaskIDs as &$tID) {
            $myTask = new Task();
            $myTask = $myTask->get_by_ID($tID['Task']);
            array_push($myTaskList, $myTask);
        }
        return $myTaskList;
      }
    }

    // function to find List of Task assigned with status 'WORKING'
    public function get_working_tasks(){
      if($this->ID != NULL){
        $allMyTasks = $this->get_tasks();
        $myWorkingTasks = array();
        foreach ($allMyTasks as &$myTask) {
            if($myTask->status == 'WORKING') {
              array_push($myWorkingTasks, $myTask);
            }
        }
        return $myWorkingTasks;
      }
    }

    // function to get contact PM
    public function get_contact_PM(){
      $roleDEV = new Role();
      $roleDEV = $roleDEV->get_by_title('DEV');
      if($this->ID != NULL and $this->role == $roleDEV->ID){
        $myTeam = $this->get_team();
        $myTeamMembers = $myTeam->get_all_members();
        $myTeamPM = $myTeam->get_team_PM();
        return $myTeamPM;
      }
    }

  }



?>
