-- SQL COMMAND TO CREATE TABLE 'role'
CREATE TABLE role (
    ID int NOT NULL AUTO_INCREMENT,
    Title varchar(3) NOT NULL UNIQUE,
    Description varchar(255) NULL,
    PRIMARY KEY (ID),
    CONSTRAINT title_type CHECK (Title in ('CEO', 'PM', 'DEV'))
);
