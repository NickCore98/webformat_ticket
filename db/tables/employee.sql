-- SQL COMMAND TO CREATE TABLE 'employee'
CREATE TABLE employee (
    ID int NOT NULL AUTO_INCREMENT,
    Name varchar(255) NOT NULL,
    Surname varchar(255) NOT NULL,
    Role int NOT NULL,
    Team int,
    PRIMARY KEY (ID),
    FOREIGN KEY (Role) REFERENCES role(ID),
    FOREIGN KEY (Team) REFERENCES team(ID)
);
