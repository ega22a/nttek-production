CREATE TABLE enr_specialties (
    id INT NOT NULL AUTO_INCREMENT,
    fullname TEXT NOT NULL,
    shortname TEXT NOT NULL,
    compositeKey TEXT NOT NULL,
    budget INT NOT NULL,
    contract INT NOT NULL,
    forExtramural  BOOLEAN NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_education_levels (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    compositeKey TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_educational_docs (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_languages (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_hostel_rooms (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    price FLOAT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_category_of_citizen (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_attached_docs (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    latinName TEXT NOT NULL,
    isNessesary  BOOLEAN NOT NULL,
    forOnline  BOOLEAN NOT NULL,
    forExtramural  BOOLEAN NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_docs_for_review (
    id INT NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    fileId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (fileId) REFERENCES main_files(id)
);

CREATE TABLE enr_news (
    id INT NOT NULL AUTO_INCREMENT,
    heading TEXT NOT NULL,
    content TEXT NOT NULL,
    timestamp TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE enr_statements (
    id INT NOT NULL AUTO_INCREMENT,
    lastname TEXT NOT NULL,
    firstname TEXT NOT NULL,
    patronymic TEXT NULL,
    sex INT NOT NULL,
    educationalType INT NOT NULL,
    specialty INT NOT NULL,
    address TEXT NOT NULL,
    telephone TEXT NOT NULL,
    homeTelephone TEXT NULL,
    email TEXT NOT NULL,
    paysType TEXT NOT NULL,
    birthday TEXT NOT NULL,
    passport TEXT NOT NULL,
    previousSchool TEXT NOT NULL,
    previousSchoolDate TEXT NOT NULL,
    degree INT NOT NULL,
    previousSchoolDoc INT NOT NULL,
    previousSchoolDocData TEXT NOT NULL,
    language INT NOT NULL,
    hostel  BOOLEAN NOT NULL,
    hostelRoom INT NULL,
    hostelNumber TEXT NULL,
    category INT NULL,
    about TEXT NULL,
    mother TEXT NULL,
    father TEXT NULL,
    representative TEXT NULL,
    attachedDocs TEXT NOT NULL,
    attachedDocsPath TEXT NOT NULL,
    isExtramural  BOOLEAN NOT NULL,
    isOnline  BOOLEAN NOT NULL,
    isChecked  BOOLEAN NOT NULL,
    compositeKey TEXT NOT NULL,
    averageMark FLOAT NOT NULL,
    timestamp INT NOT NULL,
    work TEXT NULL,
    position TEXT NULL,
    workExpirence TEXT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (specialty) REFERENCES enr_specialties(id),
    FOREIGN KEY (degree) REFERENCES enr_education_levels(id),
    FOREIGN KEY (previousSchoolDoc) REFERENCES enr_educational_docs(id),
    FOREIGN KEY (language) REFERENCES enr_languages(id),
    FOREIGN KEY (hostelRoom) REFERENCES enr_hostel_rooms(id),
    FOREIGN KEY (category) REFERENCES enr_category_of_citizen(id)
);

CREATE TABLE enr_appeal (
    id INT NOT NULL AUTO_INCREMENT,
    who INT NOT NULL,
    content TEXT NOT NULL,
    answer TEXT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (who) REFERENCES enr_statements(id)
);