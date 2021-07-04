<?php
  include_once('base_model.php');
  include_once('employee.php');
  include_once('team.php');
  include_once('assignment.php');
  include_once('task.php');

  // CLASS PROJECT
  class Project extends BaseModel {
    // variables
    public $title;
    public $description;
    public $PM;

    // init function
    public function __construct(string $title=NULL, string $description=NULL,
      int $PM=NULL){
      $this->title = $title;
      $this->description = $description;
      $this->PM = $PM;
    }

    // function to get object by ID
    public function get_by_ID(int $ID) {
      $sql = "SELECT * FROM project WHERE ID=".$ID;
      $res = $this->get_by_query($sql);
      $this->ID = $ID;
      $this->title = $res[0]['Title'];
      $this->description = $res[0]['Description'];
      $this->PM = $res[0]['PM'];
      return $this;
    }

    // function to save object in DB (Insert if new or Update if alredy exists)
    public function save(){
      $this->connect_db();
      if ( $this->ID != NULL){
        $sql = "UPDATE project SET
          Title='".$this->title."',
          Description='".$this->description."',
          PM=".$this->PM." WHERE ID=".$this->ID.";";
      } else {
        $sql = "INSERT INTO project (Title, Description, PM)
          VALUES
            ('".$this->title."',
             '".$this->description."',
             ".$this->PM."
           )";
      }
      $this->myDB->exec_sql_statement($sql);
      $this->disconnect_db();
    }

    // function to delete db row
    public function delete(){
      $this->delete_from('project');
    }

    // function to get Employee Object that is Project Manager
    public function get_PM(){
      if ( $this->PM!= NULL){
        $myPM = new Employee();
        return $myPM->get_by_ID($this->PM);
      }
    }

    // function to get Team Object from Project Manager
    public function get_PM_team(){
      if ( $this->PM != NULL){
        $myPM = $this->get_PM();
        $myTeam = new Team();
        return $myTeam->get_by_ID($myPM->team);
      }
    }

    // function to get all tasks of $this project
    public function get_my_tasks(){
      if($this->ID != NULL){
        $sql = "SELECT ID FROM task WHERE Project=".$this->ID.";";
        $myTaskIDs = $this->get_by_query($sql);
        $myTaskList = array();
        foreach ($myTaskIDs as &$tID) {
            $myTask = new Task();
            $myTask = $myTask->get_by_ID($tID['ID']);
            array_push($myTaskList, $myTask);
        }
        return $myTaskList;
      }
    }

    // function to get all Assignment Objects of the Tasks created for $this project
    public function get_all_assignments(){
      if($this->ID != NULL){
        $myTaskList = $this->get_my_tasks();
        $myAssignmentList = array();
        foreach ($myTaskList as &$myTask) {
          $myAssignmentList = array_merge($myAssignmentList, $myTask->get_assignments());
        }
        return $myAssignmentList;
      }

    }

    // function to get all Employee Objects that are DEV assigned to Tasks of $this project
    public function get_all_DEVs(){
      if($this->ID != NULL){
        $myAssignmentList = $this->get_all_assignments();
        $myDEVsList = array();
        foreach ($myAssignmentList as &$myAssignment) {
          array_push($myDEVsList, $myAssignment->get_DEV());
        }
        return $myDEVsList;
      }

    }

    // function to check if is cross-team
    public function is_cross_team(){
      if($this->ID != NULL) {
        $myDEVsList = $this->get_all_DEVs();
        if (count($myDEVsList)>1){
          $old_team = $myDEVsList[0]->team;
          foreach ($myDEVsList as &$myDEV) {
            if($myDEV->team <> $old_team){
              return 'True';
            }
          }
        }
      }
      return 'False';
    }

    // fucntion to get all Project Objects
    public function get_all(){
      $myProjects = array();
      $sql = "SELECT ID FROM project";
      $myProjectIDs = $this->get_by_query($sql);
      $myProjects = array();
      foreach ($myProjectIDs as &$myProjectID){
        $myProject = new Project();
        $myProject = $myProject->get_by_ID($myProjectID['ID']);
        array_push($myProjects, $myProject);
      }
      return $myProjects;
    }

    // function to get all cross-team projects
    function get_all_cross_team_projects(){
      $myProjects = $this->get_all();
      $myCrossTeamProjects = array();
      foreach ($myProjects as &$myProject){
        if ( $myProject->is_cross_team()=='True'){
          array_push($myCrossTeamProjects, $myProject);
        }
      }
      return $myCrossTeamProjects;
    }

  }


?>
