CREATE DATABASE course;
USE course;

CREATE TABLE Users (
    user_id MEDIUMINT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE Courses (
    course_id MEDIUMINT NOT NULL AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    PRIMARY KEY (course_id)
);

CREATE TABLE enrolments (
    enrolment_id MEDIUMINT NOT NULL AUTO_INCREMENT,
    user_id MEDIUMINT NOT NULL,
    course_id MEDIUMINT NOT NULL,
    status ENUM('in progress', 'completed') NOT NULL,
    PRIMARY KEY (enrolment_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id),
    UNIQUE (user_id, course_id)
);


INSERT INTO Users (first_name, surname) VALUES ('John', 'Doe');
INSERT INTO Users (first_name, surname) VALUES ('Jane', 'Smith');
INSERT INTO Users (first_name, surname) VALUES ('Alice', 'Johnson');
INSERT INTO Users (first_name, surname) VALUES ('Bob', 'Brown');
INSERT INTO Users (first_name, surname) VALUES ('Michael', 'Clark');
INSERT INTO Users (first_name, surname) VALUES ('Mary', 'Lewis');
INSERT INTO Users (first_name, surname) VALUES ('David', 'White');
INSERT INTO Users (first_name, surname) VALUES ('Sarah', 'Hall');
INSERT INTO Users (first_name, surname) VALUES ('James', 'Allen');
INSERT INTO Users (first_name, surname) VALUES ('Patricia', 'Young');
INSERT INTO Users (first_name, surname) VALUES ('Robert', 'Hernandez');
INSERT INTO Users (first_name, surname) VALUES ('Linda', 'King');
INSERT INTO Users (first_name, surname) VALUES ('William', 'Wright');
INSERT INTO Users (first_name, surname) VALUES ('Barbara', 'Scott');
INSERT INTO Users (first_name, surname) VALUES ('Richard', 'Green');
INSERT INTO Users (first_name, surname) VALUES ('Susan', 'Adams');
INSERT INTO Users (first_name, surname) VALUES ('Joseph', 'Baker');
INSERT INTO Users (first_name, surname) VALUES ('Jessica', 'Gonzalez');
INSERT INTO Users (first_name, surname) VALUES ('Thomas', 'Nelson');
INSERT INTO Users (first_name, surname) VALUES ('Karen', 'Carter');

INSERT INTO Courses (description) VALUES ('Introduction to Computer Science');
INSERT INTO Courses (description) VALUES ('Advanced Mathematics');
INSERT INTO Courses (description) VALUES ('World History');
INSERT INTO Courses (description) VALUES ('Physics 101');
INSERT INTO Courses (description) VALUES ('Chemistry Basics');
INSERT INTO Courses (description) VALUES ('Literature and Composition');
INSERT INTO Courses (description) VALUES ('Biology Fundamentals');
INSERT INTO Courses (description) VALUES ('Principles of Economics');
INSERT INTO Courses (description) VALUES ('Software Engineering');
INSERT INTO Courses (description) VALUES ('Political Science');
INSERT INTO Courses (description) VALUES ('Art History');
INSERT INTO Courses (description) VALUES ('Basic Engineering');
INSERT INTO Courses (description) VALUES ('Statistics');
INSERT INTO Courses (description) VALUES ('Philosophy');
INSERT INTO Courses (description) VALUES ('Environmental Science');
INSERT INTO Courses (description) VALUES ('Sociology');
INSERT INTO Courses (description) VALUES ('Psychology');
INSERT INTO Courses (description) VALUES ('Graphic Design');
INSERT INTO Courses (description) VALUES ('Music Theory');
INSERT INTO Courses (description) VALUES ('Physical Education');

INSERT INTO enrolments (user_id, course_id, status) VALUES (16, 16, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (4, 11, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 2, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (15, 16, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 7, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (13, 12, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (7, 17, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (2, 13, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (12, 4, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (2, 9, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 14, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (10, 18, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 2, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (9, 19, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (12, 5, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (20, 7, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (6, 19, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 10, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (14, 15, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (5, 19, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (19, 3, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 15, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (9, 12, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (4, 17, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (11, 18, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (8, 6, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (4, 15, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 20, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 10, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (4, 5, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (11, 8, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (4, 14, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (5, 3, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (15, 14, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (15, 5, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (11, 16, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (10, 3, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (2, 20, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (20, 11, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (19, 2, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (5, 16, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (19, 7, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (17, 14, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (12, 6, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (11, 12, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (20, 1, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 18, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (12, 9, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (14, 5, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (9, 10, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (4, 1, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (13, 6, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (2, 18, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (17, 11, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 6, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (7, 10, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (14, 3, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (15, 12, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (8, 3, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (13, 19, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (6, 18, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (14, 14, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (2, 12, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (8, 4, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (2, 19, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (6, 9, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (5, 14, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (17, 20, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (6, 7, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 6, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (8, 10, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (17, 10, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (12, 20, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 13, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (16, 19, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (16, 9, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (11, 13, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (20, 10, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (13, 15, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (19, 19, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (8, 9, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 17, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (9, 8, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (13, 18, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 18, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (12, 15, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (7, 18, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (1, 17, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (10, 5, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (3, 11, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (6, 20, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (18, 16, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (17, 15, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (15, 6, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (7, 5, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (7, 6, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (5, 15, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (11, 4, 'completed');
INSERT INTO enrolments (user_id, course_id, status) VALUES (9, 20, 'in progress');
INSERT INTO enrolments (user_id, course_id, status) VALUES (16, 7, 'in progress');