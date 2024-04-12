CREATE DATABASE IF NOT EXISTS userDatabase; 
USE userDatabase;

CREATE TABLE users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100) UNIQUE,
    Password VARCHAR(255),
    companyID INT
);

CREATE TABLE Role (
    RoleID INT AUTO_INCREMENT PRIMARY KEY,
    RoleName VARCHAR(50)
)

CREATE TABLE UserRole ( 
    UserRoleID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    RoleID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (RoleID) REFERENCES Role(RoleID)
)

CREATE TABLE Project ( 
    ProjectID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(200),
    Description VARCHAR(1000)
)

CREATE TABLE TimeEntry (
    TimeEntryID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    ProjectID INT,
    ClockInTime DATETIME,
    ClockOutTime DATETIME,
    Description VARCHAR(1000), 
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (ProjectID) REFERENCES Project(ProjectID),
);


CREATE TABLE ProjectAssignment (
    ProjectAssignmentID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    ProjectID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (ProjectID) REFERENCES Project(ProjectID)
);

