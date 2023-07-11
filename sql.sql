CREATE DATABASE vuejs_notes;

CREATE TABLE contacts (
    id INT NOT NULL AUTO_INCREMENT,    
    username VARCHAR(30) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(50) NOT NULL,
    picture VARCHAR(40) NOT NULL DEFAULT '',
    PRIMARY KEY(id),
    UNIQUE(email)
);

CREATE TABLE notes (
    id INT NOT NULL AUTO_INCREMENT,    
    annotations VARCHAR(150) NOT NULL,
    PRIMARY KEY(id)    
);