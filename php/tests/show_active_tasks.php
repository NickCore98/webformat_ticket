<?php
  include_once(__DIR__.'/../models/employee.php');

  echo "--- SHOWING ACTIVE TASK ---\n";
  echo "USING DEV\n";
  $myDEV = new Employee();
  $myDEV = $myDEV->get_by_ID(rand(5, 19));
  print_r($myDEV);

  echo "LIST OF ACTIVE TASKS\n";
  $myTaskList = $myDEV->get_working_tasks();
  print_r($myTaskList);

?>
