-- SQL FUNCTION TO CHECK IF AN EMPLOYEE HAS 'PM' ROLE
CREATE FUNCTION check_PM (employee_id int)
RETURNS BOOLEAN

BEGIN

   DECLARE role VARCHAR(3);
   SET role = (
     SELECT Title FROM role as A
     inner join employee as B on A.ID=B.Role
     WHERE B.ID=employee_id
   );

  RETURN role='PM';

END;
