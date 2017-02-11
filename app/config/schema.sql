
CREATE TABLE IF NOT EXISTS users (
   id           INT(6)         NOT NULL AUTO_INCREMENT, 
   username     VARCHAR(25)    NOT NULL, 
   password     VARCHAR(25)    NOT NULL,
   PRIMARY KEY (ID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS statuses (
   id           INT(6)          NOT NULL AUTO_INCREMENT, 
   message      VARCHAR(500)    NOT NULL, 
   name         VARCHAR(250)    NOT NULL,
   date         DATETIME        NOT NULL,
   PRIMARY KEY (ID),
   CONSTRAINT fk_UserId
   FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;