use alajiradb;

CREATE TABLE User (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255),
  name VARCHAR(255) NOT NULL,
  surname VARCHAR(255) NOT NULL,
  role INT NOT NULL,
  department INT NOT NULL
);