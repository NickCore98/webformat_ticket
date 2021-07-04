<?php
  // CLASS FOR BUILDING UP TABLES, FUNCTION AND TRIGGER
  include_once('db.php');

  class DBBuilder {


    public $myDB;
    // variables with function names
    public $func_dir = "functions";
    public $func_names = array("check_DEV", "check_PM");

    // variables with tables names
    public $tables_dir = "tables";
    public $tables_names = array("role", "team", "employee", "project", "task", "assignment");

    // variables with trigger names
    public $trig_dir = "triggers";
    public $trig_names = array("check_unique_CEO");

    // reading file content
    function get_file_content($rel_path){
      $myfile = fopen(__DIR__.$rel_path, "r") or die("Unable to open file!");
      $content =  fread($myfile, filesize(__DIR__.$rel_path));
      fclose($myfile);
      return $content;
    }

    // execute sql statement written on file
    function execute_from_file($rel_dir, $file_name){
      $rel_path = "/".$rel_dir."/".$file_name.".sql";
      $sql = $this->get_file_content($rel_path);
      $this->myDB->exec_sql_statement($sql);
    }

    // execute sql statements written on files inside given table
    function execute_sql_from_files($rel_dir, $file_names){
      foreach ($file_names as &$f_name) {
        $this->execute_from_file($rel_dir, $f_name);
      }
    }


    // main function
    function setup(){

      // open connection
      $this->myDB = new MyDB();
      $this->myDB->open_connection();

      // create functions
      $this->execute_sql_from_files($this->func_dir, $this->func_names);

      // create tables
      $this->execute_sql_from_files($this->tables_dir, $this->tables_names);

      // create triggers
      $this->execute_sql_from_files($this->trig_dir, $this->trig_names);
      $this->myDB->close_connection();
    }


  }


?>
