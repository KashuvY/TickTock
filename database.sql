CREATE DATABASE IF NOT EXISTS userDatabase;
USE userDatabase;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    company_id INT,
    access_level INT
);

CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200),
    description VARCHAR(1000),
    user_access JSON
);

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

