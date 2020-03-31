CREATE DATABASE doings_done CHARACTER SET utf8 COLLATE utf8_general_ci;
use doings_done;
CREATE TABLE users (
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(50) NOT NULL,
    date_of_registration TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE projects (
    id_project INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL UNIQUE,
    id_user    INT          NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users (id_user)
);
CREATE TABLE tasks (
    id_task INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date_of_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(1) NOT NULL DEFAULT 0,
    name_task VARCHAR(255) NOT NULL,
    file VARCHAR(255),
    date_of_completion DATE,
    id_project INT NOT NULL,
    FOREIGN KEY (id_project) REFERENCES projects (id_project)
 );
