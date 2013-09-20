//create database mar;
use mar;

CREATE TABLE IF NOT EXISTS users (
   uid INT(5) NOT NULL AUTO_INCREMENT,
   name VARCHAR(64) NOT NULL,
   status INT(2) DEFAULT 1,
   PRIMARY KEY(uid)
) ENGINE=INNODB CHARSET 'utf8';


CREATE TABLE IF NOT EXISTS games (
   id INT(8) NOT NULL AUTO_INCREMENT,
   date DATE NOT NULL,
   fstu INT(5) NOT NULL,
   sndu INT(5) NOT NULL,
   thru INT(5) NOT NULL,
   foru INT(5) NOT NULL,
   fstp INT(5) NOT NULL,
   sndp INT(5) NOT NULL,
   thrp INT(5) NOT NULL,
   forp INT(5) NOT NULL,   
   status INT(2) DEFAULT 1,
   mtime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   ctime DATETIME NOT NULL DEFAULT "0000-00-00 00\:00\:00",
   PRIMARY KEY(id)
) ENGINE=INNODB CHARSET 'utf8';