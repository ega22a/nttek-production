CREATE TABLE main_users (
    id INT NOT NULL AUTO_INCREMENT,
    lastname TEXT NOT NULL,
    firstname TEXT NOT NULL,
    patronymic TEXT NULL,
    birthday TEXT NOT NULL,
    email TEXT NOT NULL,
    telephone TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE main_user_auth (
    id INT NOT NULL AUTO_INCREMENT,
    login TEXT NOT NULL,
    password TEXT NOT NULL,
    levels TEXT NOT NULL,
    token TEXT NULL,
    usersId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (usersId) REFERENCES main_users(id)
);

CREATE TABLE main_modules (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    latinName TEXT NOT NULL,
    menuPieces JSON NULL,
    relativePath TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE main_files (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    mime TEXT NOT NULL,
    path TEXT NOT NULL,
    isCommon BOOLEAN NOT NULL,
    shared JSON NULL,
    PRIMARY KEY (id)
);
