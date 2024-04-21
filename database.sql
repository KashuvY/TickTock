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

CREATE TABLE time_entries (
    time_entry_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    project_id INT,
    clock_in_time DATETIME,
    clock_out_time DATETIME,
    description VARCHAR(1000),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (project_id) REFERENCES projects(project_id)
);