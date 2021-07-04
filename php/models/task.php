<?php
  include_once('base_model.php');
  include_once('project.php');
  include_once(__DIR__.'/../interfaces/assignment_interface.php');

  // CLASS TaskTHAT IMPLEMENTS 'AssignmentsInterface' METHODS
  class Task extends BaseModel implements AssignmentsInterface {
    // variables
    public $description;
    public $status;
    public $deadline;
    public $project;

    // init function
    public function __construct(string $description=NULL, string $status=NULL,
      DateTime $deadline=NULL, int $project=NULL){
      $this->description = $description;
      $this->status = $status;
      $this->deadline = $deadline;
      $this->project = $project;
    }

    // function to get object by ID
    public function get_by_ID(int $ID) {
      $sql = "SELECT * FROM task WHERE ID=".$ID;
      $res = $this->get_by_query($sql);
      $this->ID = $ID;
      $this->description = $res[0]['Description'];
      $this->status = $res[0]['Status'];
      $this->deadline = $res[0]['Deadline'];
      $this->project = $res[0]['Project'];
      return $this;
    }

    // function to save object in DB (Insert if new or Update if alredy exists)
    public function save(){
      $this->connect_db();
      if ( $this->ID != NULL){
        $sql = "UPDATE task SET
          Description='".$this->description."',
          Status='".$this->status."',
          Deadline=".$this->deadline->format('Y-m-d').",
          Project=".$this->project." WHERE ID=".$this->ID.";";
      } else {
        $sql = "INSERT INTO task (Description, Status, Deadline, Project)
          VALUES
            ('".$this->description."',
             '".$this->status."',
             '".$this->deadline->format('Y-m-d')."',
             ".$this->project."
           )";
      }
      $this->myDB->exec_sql_statement($sql);
      // retrive ID if new
      if ( $this->ID == NULL){
        $sql = "SELECT ID FROM task WHERE Description='".$this->description."' and
          Status='".$this->status."' and  Deadline='".$this->deadline->format('Y-m-d')."'
          and Project=".$this->project;
        $res = $this->get_by_query($sql);
        $this->ID = $res[0]['ID'];
      }
      $this->disconnect_db();
      return $this;
    }

    // function to delete db row
    public function delete(){
      $this->delete_from('task');
    }

    // function to get project
    public function get_project(){
      if ( $this->project != NULL){
        $myProject= new Project();
        return $myProject->get_by_ID($this->project);
      }
    }

    // function to check if Task is in time
    public function is_in_time(DateTime $date=NULL){
      if ( $this->deadline != NULL){
        if ($date==NULL){ $date=date_create(date("Y/m/d")); }
        if (date_create($this->deadline) <= $date){
          return 'True';
        } else {
          return 'False';
        }
      }
    }

    // function to get all Assignment Objects
    public function get_assignments(){
      if($this->ID != NULL){
        $sql = "SELECT ID FROM assignment WHERE Task=".$this->ID.";";
        $myAssignmentIDs = $this->get_by_query($sql);
        $myAssignmentsList = array();
        foreach ($myAssignmentIDs as &$aID) {
            $myAssignment = new Assignment();
            $myAssignment = $myAssignment->get_by_ID($aID['ID']);
            array_push($myAssignmentsList, $myAssignment);
        }
        return $myAssignmentsList;
      }
    }

    // implements interface method 'assign' creating assignment with Employee Object given
    public function assign($objToAssign){
      if($this->ID != NULL and
         $objToAssign instanceof Employee and
         $objToAssign->ID != NULL){
        $myAssignment = new Assignment($this->ID, $objToAssign->ID);
        return $myAssignment->save();
      }
    }

    // implements interface method 'remove_assignment' removing existing assignment with Employee Object given
    public function remove_assignment($objToAssign){
      if($this->ID != NULL and
        $objToAssign instanceof Employee and
        $objToAssign->ID != NULL){
        $myAssignment = new Assignment();
        $myAssignment = $myAssignment->get_by_task_DEV($this->ID, $objToAssign->ID);
        $myAssignment->delete();
        return $myAssignment;
      }
    }

  }

?>
