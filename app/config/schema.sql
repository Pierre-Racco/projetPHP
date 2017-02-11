
CREATE TABLE IF NOT EXISTS users (
   id           VARCHAR(9)     NOT NULL, 
   username     VARCHAR(25)    NOT NULL, 
   password     VARCHAR(25)    NOT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS statuses (
   id           VARCHAR(9)      NOT NULL, 
   message      VARCHAR(500)    NOT NULL, 
   user_id      VARCHAR(9)    NOT NULL,
   date         DATETIME        NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_UserId
   FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;