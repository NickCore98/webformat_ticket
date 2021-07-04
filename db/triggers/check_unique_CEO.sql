-- SQL COMMAND TO CREATE TRIGGER  'CHK_UNIQUE_CEO'
CREATE TRIGGER CHK_UNIQUE_CEO
    BEFORE INSERT
    ON employee FOR EACH ROW
    BEGIN
      SET @CEO_ROLE = (SELECT ID FROM role WHERE TITLE='CEO');
      IF NEW.Role=@CEO_ROLE  AND
        (SELECT COUNT(*) FROM employee WHERE Role=@CEO_ROLE)>0
        THEN
          SIGNAL sqlstate '45001' set message_text = "There is already a CEO!";
      END IF;
    END;
