CREATE TABLE example (
  id int(10) NOT NULL AUTO_INCREMENT,
  text text NOT NULL,
  counter int(10) NOT NULL,
  toggle tinyint(1) DEFAULT 1 NOT NULL,
  PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE main_sub (
  mainid int(10) NOT NULL,
  subid  int(10) NOT NULL,
  PRIMARY KEY (mainid,
  subid)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE sub (
  id    int(10) NOT NULL AUTO_INCREMENT,
  value text NOT NULL,
  PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE main (
  id      int(10) NOT NULL AUTO_INCREMENT,
  name    varchar(255) NOT NULL,
  sub_id  int(10) NOT NULL,
  sub2_id int(10) NOT NULL,
  PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE main_sub ADD INDEX `main has many sub` (mainid), ADD CONSTRAINT `main has many sub` FOREIGN KEY (mainid) REFERENCES main (id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE main_sub ADD INDEX `sub has many main` (subid), ADD CONSTRAINT `sub has many main` FOREIGN KEY (subid) REFERENCES sub (id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE main ADD INDEX `main has sub2` (sub2_id), ADD CONSTRAINT `main has sub2` FOREIGN KEY (sub2_id) REFERENCES sub (id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE main ADD INDEX `main has sub` (sub_id), ADD CONSTRAINT `main has sub` FOREIGN KEY (sub_id) REFERENCES sub (id) ON UPDATE Cascade ON DELETE Cascade;
