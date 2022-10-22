CREATE DATABASE sk_php_mvc_test;
CREATE DATABASE sk_php_mvc;

CREATE TABLE users(
    id VARCHAR(10) PRIMARY KEY ,
    username VARCHAR(255) NOT NULL ,
    password VARCHAR(255) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE sessions(
    id VARCHAR(10) PRIMARY KEY ,
    user_id VARCHAR(10) NOT NULL
) ENGINE = InnoDB;

ALTER TABLE sessions
ADD CONSTRAINT fk_sessions_users FOREIGN KEY sessions(user_id) REFERENCES users(id);

ALTER TABLE sessions
MODIFY COLUMN id VARCHAR(255) ;

SHOW CREATE TABLE sessions;