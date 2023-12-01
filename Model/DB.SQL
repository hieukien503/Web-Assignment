-- The mariaDB in phpmysql can run the following code
-- I set auto_increment for not needing to add ID into db, it auto increases for us
-- insert 1 doctor, 2 patient account to see how it works
DROP DATABASE IF EXISTS BOOKING_APPOINTMENT;

CREATE DATABASE BOOKING_APPOINTMENT;

USE BOOKING_APPOINTMENT;

CREATE TABLE Users (	
    userID INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(256) UNIQUE,
    email VARCHAR(256) NOT NULL,
    password VARCHAR(1024) NOT NULL,
    role BOOLEAN DEFAULT 0
);

CREATE TABLE Appointment (
    appointment_ID INT AUTO_INCREMENT PRIMARY KEY,
    appointment_date DATE NOT NULL,
    appointment_timeslot VARCHAR(256) NOT NULL,
    appointment_patientID INT,
    appointment_doctorID INT,
    appointment_status CHAR(1),
    CONSTRAINT fk_patientID FOREIGN KEY (appointment_patientID) REFERENCES Users(userID) ON DELETE SET NULL,
    CONSTRAINT fk_doctorID FOREIGN KEY (appointment_doctorID) REFERENCES Users(userID) ON DELETE SET NULL
);
