<?php
  include_once(__DIR__.'/../models/project.php');

  echo "--- SHOWING ALL CROSS TEAM PROJECTS ---\n";
  $myCrossTeamProjects =  new Project();
  $myCrossTeamProjects =  $myCrossTeamProjects->get_all_cross_team_projects();
  print_r($myCrossTeamProjects);

?>
