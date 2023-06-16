use alajiradb;

CREATE TABLE Comment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  ticket_id INT NOT NULL,
  body VARCHAR(510) NOT NULL
);