
CREATE TABLE IF NOT EXISTS users (
   id           INT            NOT NULL AUTO_INCREMENT, 
   username     VARCHAR(25)    NOT NULL, 
   password     VARCHAR(25)    NOT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS statuses (
   id           INT             NOT NULL AUTO_INCREMENT, 
   message      VARCHAR(500)    NOT NULL, 
   user_id      INT             NOT NULL,
   date         DATETIME        NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_UserId
   FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;