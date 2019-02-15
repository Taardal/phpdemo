CREATE DATABASE IF NOT EXISTS svitts;
USE svitts;

DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` INT NOT NULL UNIQUE AUTO_INCREMENT,
  `imdbId` VARCHAR(255) NOT NULL UNIQUE,
  `title` VARCHAR(255) NOT NULL,
  `year` INT,
  PRIMARY KEY(`id`)
);

INSERT INTO movie (`imdbId`, `title`, `year`) VALUES ('tt6105098', 'The Lion King', 2019);
INSERT INTO movie (`imdbId`, `title`, `year`) VALUES ('tt4532826', 'Robin Hood', 2018);