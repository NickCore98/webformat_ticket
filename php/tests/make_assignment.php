<?php
  include_once(__DIR__.'/../models/employee.php');
  include_once(__DIR__.'/../models/task.php');
  include_once(__DIR__.'/../models/assignment.php');

  echo "--- MAKING RANDOM ASSIGNMENT ---\n";

  echo "--- ASSIGNMENT DEV TO TASK ---\n";
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
      $myAssignment = NULL;
      $myAssignment = $myDEV->assign($myTask);
      print_r($myAssignment);
      break;
    } else {
      echo "ASSIGNMENT ALREADY EXISTS:\n";
      print_r($myAssignment);
      echo "TRYING NEW ASSIGNMENT\n";
    }
  }

  echo "--- ASSIGNMENT TASK TO DEV ---\n";
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
      $myAssignment2 = NULL;
      $myAssignment2 = $myTask2->assign($myDEV2);
      print_r($myAssignment2);
      break;
    } else {
      echo "ASSIGNMENT ALREADY EXISTS:\n";
      print_r($myAssignment2);
      echo "TRYING NEW ASSIGNMENT\n";
    }
  }
?>
