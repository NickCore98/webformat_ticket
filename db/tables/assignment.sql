-- SQL COMMAND TO CREATE TABLE 'assignment'
CREATE TABLE assignment (
    ID int NOT NULL AUTO_INCREMENT,
    Task int NOT NULL,
    DEV int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (Task) REFERENCES task(ID),
    FOREIGN KEY (DEV) REFERENCES employee(ID),
    CONSTRAINT CHK_DEV CHECK (check_DEV(DEV))
);
