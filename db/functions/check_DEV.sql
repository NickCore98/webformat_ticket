-- SQL FUNCTION TO CHECK IF AN EMPLOYEE HAS 'DEV' ROLE
CREATE FUNCTION check_DEV (employee_id int)
RETURNS BOOLEAN

BEGIN

   DECLARE role VARCHAR(3);
   SET role = (
     SELECT Title FROM role as A
     inner join employee as B on A.ID=B.Role
     WHERE B.ID=employee_id
   );

  RETURN role='DEV';

END;
