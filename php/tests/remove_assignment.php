<?php
  include_once(__DIR__.'/../models/employee.php');
  include_once(__DIR__.'/../models/task.php');
  include_once(__DIR__.'/../models/assignment.php');

  echo "--- REMOVING RANDOM ASSIGNMENT ---\n";

  echo "--- REMOVING ASSIGNMENT DEV TO TASK ---\n";
  while (true){
    echo "USING DEV:\n";
    $myDEV = new Employee();
    $myDEV = $myDEV->get_by_ID(rand(5, 19));
    print_r($myDEV);

    echo "USING TASK:\n";
    $myTask = new Task();
    $myTask = $myTask->get_by_ID(rand(1, 20));
    print_r($myTask);
    $myAssignment = new Assignment();
    $myAssignment = $myAssignment->get_by_task_DEV($myTask->ID, $myDEV->ID);
    if($myAssignment->ID==NULL){
      echo "ASSIGNMENT NOT EXISTS\n";
      $myAssignment = NULL;
    } else {
      echo "REMOVING ASSIGNMENT\n";
      print_r($myAssignment);
      $myDEV->remove_assignment($myTask);
      break;
    }
  }

  echo "--- REMOVING TASK TO DEV ---\n";
  while (true){
    echo "USING DEV:\n";
    $myDEV2 = new Employee();
    $myDEV2 = $myDEV2->get_by_ID(rand(5, 19));
    print_r($myDEV2);

    $myTask2 = new Task();
    $myTask2 = $myTask2->get_by_ID(rand(1, 20));
    print_r($myTask2);

    $myAssignment2 = new Assignment();
    $myAssignment2 = $myAssignment2->get_by_task_DEV($myTask2->ID, $myDEV2->ID);
    if($myAssignment2->ID==NULL){
      echo "ASSIGNMENT NOT EXISTS\n";
      $myAssignment2 = NULL;
    } else {
      echo "REMOVING ASSIGNMENT\n";
      print_r($myAssignment2);
      $myTask2->remove_assignment($myDEV2);
      break;
    }
  }
?>
