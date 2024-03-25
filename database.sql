CREATE DATABASE IF NOT EXISTS userDatabase;
USE userDatabase;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    employee_id INT
);

CREATE TABLE userRoles ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    user_role ENUM('employee', 'manager', 'admin') NOT NULL
)

CREATE TABLE projects ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    project_title VARCHAR(100)
)

CREATE TABLE TimeEntries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    project_id INT,
    clock_in_time DATETIME,
    clock_out_time DATETIME,
    description VARCHAR(255), --employees can add a description of their work done
    FOREIGN KEY (employee_id) REFERENCES users(employee_id),
    FOREIGN KEY (project_id) REFERENCES projects(project_id),
    CONSTRAINT FK_employeeProject -- ensures that employees can only attribute time entries to projects they have been assigned
        FOREIGN KEY (employee_id, project_id) 
        REFERENCES employeeProjects(employee_id, project_id)
);


CREATE TABLE employeeProjects (
    employee_id INT,
    project_id INT,
    PRIMARY KEY (employee_id, project_id),
    FOREIGN KEY (employee_id) REFERENCES users(employee_id),
    FOREIGN KEY (project_id) REFERENCES Projects(project_id)
);

