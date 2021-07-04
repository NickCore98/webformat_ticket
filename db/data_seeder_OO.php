<?php
  // CLASS FOR DATA SEEDING IN NEW DATABASE
  foreach (glob(__DIR__."/../php/models/*.php") as $filename) {
    include_once $filename;
  }

  class DataSeeder {

    // Variables
    public $roles = array(
      array("Title"=>"CEO", "Description"=>"Chief Executive Officer"),
      array("Title"=>"PM", "Description"=>"Project Manager"),
      array("Title"=>"DEV", "Description"=>"Developer")
    );
    public $team_names = array('Alpha', 'Bravo', 'Charlie');

    public $possible_names = array("Giuseppe", "Maria", "Giovanni", "Anna", "Antonio",
      "Giuseppina", "Mario", "Rosa", "Luigi", "Angela", "Francesco", "Giovanna",
      "Angelo", "Teresa", "Vincenzo", "Lucia", "Pietro", "Carmela");
    public $possible_surnames = array("Rossi", "Ferrari", "Russo", "Bianchi", "Esposito",
      "Colombo","Romano","Ricci", "Gallo", "Greco", "Conti", "Marino", "De Luca",
      "Bruno", "Costa");

    public $projects_titles = array('Coca-Cola', 'Nike', 'Pepsi', 'Adidas', 'Canon',
     'Lego', 'Nintendo', 'Nokia', 'Sony', 'Disney');

    public $possible_task_descr = array("Analisys", "Develop", "Testing", "Documentation", "Bug Fix");
    public $possible_task_status = array('OPEN', 'WORKING', 'CLOSE');

    public $all_PMs = array();
    public $all_DEVs = array();

    public $all_projects = array();
    public $all_tasks = array();

    // function to get one random element from a give array
    public function get_random($array){
      return $array[array_rand($array, 1)];
    }

    // function to insert roles in db
    public function insert_roles(){
      foreach ($this->roles as &$role_detail) {
          $myRole = new Role($role_detail['Title'], $role_detail['Description']);
          $myRole->save();
      }
    }

    // function to insert teams in db
    public function insert_teams(){
      foreach ($this->team_names as &$team_name) {
        $myTeam = new Team($team_name);
        $myTeam->save();
      }
    }

    // function to insert employees in db
    public function insert_employees(){
      // only one CEO
      $CEO_Role = new Role();
      $CEO_Role = $CEO_Role->get_by_title('CEO');
      $CEO = new Employee($this->get_random($this->possible_names),
        $this->get_random($this->possible_surnames),
        $CEO_Role->ID,
        NULL);
      $CEO->save();

      // a PM for every team
      $PM_Role = new Role();
      $PM_Role = $PM_Role->get_by_title('PM');
      for($i = 1; $i<=count($this->team_names); $i++){
        $PM = new Employee($this->get_random($this->possible_names),
          $this->get_random($this->possible_surnames),
          $PM_Role->ID,
          $i);
        $PM = $PM->save();
        array_push($this->all_PMs, $PM);
      }

      // 15 DEVs
      $DEV_Role = new Role();
      $DEV_Role = $DEV_Role->get_by_title('DEV');
      for($i = 1; $i<=15; $i++){
        $DEV = new Employee($this->get_random($this->possible_names),
          $this->get_random($this->possible_surnames),
          $DEV_Role->ID,
          rand(1, count($this->team_names)));
        $DEV->save();
        array_push($this->all_DEVs, $DEV);
      }

    }


    // function to insert projects in db
    public function insert_projects(){
      foreach ($this->projects_titles as &$project_title) {
        $myPM = $this->get_random($this->all_PMs);
        $myProject = new Project($project_title,
          "Description for project ".$project_title,
          $myPM->ID
        );
        $myProject = $myProject->save();
        print_r($myProject);
        array_push($this->all_projects, $myProject);
      }
    }

    // function to insert tasks in db
    public function insert_tasks(){

      // date range
      $min_date = strtotime(date('2021-01-01'));
      $max_date = strtotime(date('2022-01-01'));

      $this->all_projects = new Project();
      $this->all_projects = $this->all_projects->get_all();
      foreach ($this->all_projects as &$myProject) {
        $n_tasks = rand(1, count($this->possible_task_descr));
        for($i=0; $i<$n_tasks; $i++){
          $rand_date = rand($min_date, $max_date);
          // create tasks in order of variable description given
          $myTask = new Task($this->possible_task_descr[$i],
            $this->get_random($this->possible_task_status),
            new DateTime(date("Y-m-d H:i:s", $rand_date)),
            $myProject->ID);
          $myTask = $myTask->save();
          array_push($this->all_tasks, $myTask);
        }
      }

    }

    // function to insert assignments in db
    public function insert_assignments(){
      // assign a random task to each DEV
      foreach ($this->all_DEVs as &$myDEV) {
        $myRndTask = $this->get_random($this->all_tasks);
        $myDEV->assign($myRndTask);
      }

      // assign up to 2 random DEV to each Task
      foreach ($this->all_tasks as &$myTask) {
        for($i=0; $i<2; $i++){
          $myRndDEV = $this->get_random($this->all_DEVs);
          $myAssignment = new Assignment();
          $myAssignment = $myAssignment->get_by_task_DEV($myTask->ID, $myRndDEV->ID);
          if($myAssignment->ID == NULL){
            $myTask->assign($myRndDEV);
          }
        }
      }
    }

    // main function
    public function run(){

      // insert defualt roles
      $this->insert_roles();

      // insert defualt teams
      $this->insert_teams();

      // insert defualt employees
      $this->insert_employees();

      // insert defualt projects
      $this->insert_projects();

      // insert defualt tasks
      $this->insert_tasks();

      // insert defualt assignments
      $this->insert_assignments();

    }

  }

?>
