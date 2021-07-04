<?php
  include_once(__DIR__.'/../models/project.php');

  echo "--- SHOWING CONTACT PM OF A DEV ---\n";
  echo "USING DEV:\n";
  $myDEV = new Employee();
  $myDEV = $myDEV->get_by_ID(rand(5, 19));
  print_r($myDEV);

  echo "CONTACT PM:\n";
  $myContactPM = $myDEV->get_contact_PM();
  print_r($myContactPM);

?>
