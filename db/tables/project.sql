-- SQL COMMAND TO CREATE TABLE 'project'
CREATE TABLE project (
    ID int NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL UNIQUE,
    Description varchar(255) NULL,
    PM int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (PM) REFERENCES employee(ID),
    CONSTRAINT CHK_PM CHECK (check_PM(PM))
);
