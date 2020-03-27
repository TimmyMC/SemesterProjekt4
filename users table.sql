CREATE TABLE users(
id serial PRIMARY KEY,
username varchar(20) UNIQUE NOT NULL,
password varchar (250) NOT NULL
)

INSERT INTO users (username, password)
VALUES('user','12345');
INSERT INTO users (username, password)
VALUES('test','12345');