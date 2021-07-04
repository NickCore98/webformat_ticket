-- SQL COMMAND TO CREATE TABLE 'task'
CREATE TABLE task (
    ID int NOT NULL AUTO_INCREMENT,
    Description varchar(255) NOT NULL,
    Status VARCHAR(255) NOT NULL,
    Deadline date NOT NULL,
    Project int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (Project) REFERENCES project(ID),
    CONSTRAINT status_type CHECK (Status in ('OPEN', 'WORKING', 'CLOSE'))
);
