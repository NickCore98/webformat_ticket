<?php

  include_once(__DIR__.'/../db/db_builder.php');
  include_once(__DIR__.'/../db/data_seeder_OO.php');

  echo "--- BUILDING DATABASE ---\n";

  $myDBBuilder = new DBBuilder();
  $myDBBuilder->setup();

  echo "--- DONE ---\n";

  echo "--- STATING DATA SEEDING ---\n";

  $myDataSeeder = new DataSeeder();
  $myDataSeeder->run();

  echo "--- DONE ---\n";





?>
