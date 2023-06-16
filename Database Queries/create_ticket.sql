CREATE TABLE Ticket (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  priority INT NOT NULL,
  department INT NOT NULL,
  assignee VARCHAR(255) NOT NULL,
  attachment VARCHAR(255),
  date_added DATE NOT NULL,
  date_closed DATE,
  deadline DATE NOT NULL,
  is_closed TINYINT(1) DEFAULT 0
);