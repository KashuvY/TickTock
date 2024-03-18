CREATE DATABASE IF NOT EXISTS userDatabase;
USE userDatabase;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    company_id INT,
);

CREATE TABLE userRoles ( --can probably be combined with table above, but need to change submit registration file
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT;
    user_role ENUM('employee', 'manager', 'admin') NOT NULL
)

CREATE TABLE projects ( --shouldn't be in userdatabase (will fix)
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT;
    project_title VARCHAR(100)
)

CREATE TABLE timeEntries ( --shouln't be in userdatabase
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    project_id INT,
    clock_in_time DATETIME,
    clock_out_time DATETIME,
    description VARCHAR(255), --employees can add a description of their work done
    CONSTRAINT FK_employee FOREIGN KEY (company_id) REFERENCES users(company_id),
    CONSTRAINT FK_project FOREIGN KEY (project_id) REFERENCES projects(project_id)
)
