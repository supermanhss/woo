CREATE TABLE IF NOT EXISTS venue (
  id int(11) NOT NULL auto_increment,
  name varchar(60),
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS space (
  id int(11) NOT NULL auto_increment,
  venue int(11) NOT NULL,
  name varchar(60) NOT NULL,
  PRIMARY KEY (id),
  KEY (venue)
);

CREATE TABLE IF NOT EXISTS event (
  id int(11) NOT NULL auto_increment,
  space int(11) NOT NULL,
  start varchar(50) DEFAULT NULL,
  duration int(11) DEFAULT NULL,
  name varchar(100) NOT NULL,
  PRIMARY KEY (id)
);