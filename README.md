# Ticketing System

## SETUP
- clone this folder
- run in your shell the command "cd webformat_ticket"
- run command "docker-compose up"
  - this will install the needed containers, the next time use "docker-compose start"
- to build the DataBase and execute the Data Seeding run "php php/setup.php"

## RUNNING PROCESSES
- WebServer: http://localhost:8100
- DataBase: mysql://devuser:devpass@localhost:9906/test_db

## TEST FUNCTIONS
- Assign Task to DEV
  - run "php php/tests/make_assignment.php"
- Remove Assignment
  - run "php php/tests/remove_assignment.php"
- Show all Tasks with status "WORKING" of a DEV
  - run "php php/tests/show_active_tasks.php"
- Show all cross-team Projects
  - run "php php/tests/show_cross_projects.php"
  - to check the result you can execute directly the query written in the file "php/tests/check_cross_projects.sql"
- Show contact PM of a DEV
  - run "php php/tests/show_contact_PM.php"
