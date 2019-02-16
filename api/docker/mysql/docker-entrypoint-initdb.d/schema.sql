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

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` INT NOT NULL UNIQUE AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL UNIQUE,
  PRIMARY KEY(`id`)
);

DROP TABLE IF EXISTS `movie_genre`;
CREATE TABLE `movie_genre` (
  `id` INT NOT NULL UNIQUE AUTO_INCREMENT,
  `movie_id_fk` INT NOT NULL UNIQUE,
  `genre_id_fk` INT NOT NULL UNIQUE,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`movie_id_fk`) REFERENCES `movie`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`genre_id_fk`) REFERENCES `genre`(`id`) ON DELETE CASCADE
);

INSERT INTO genre (`name`) VALUES ('Action');
INSERT INTO genre (`name`) VALUES ('Adult');
INSERT INTO genre (`name`) VALUES ('Adventure');
INSERT INTO genre (`name`) VALUES ('Animation');
INSERT INTO genre (`name`) VALUES ('Children');
INSERT INTO genre (`name`) VALUES ('Comedy');
INSERT INTO genre (`name`) VALUES ('Crime');
INSERT INTO genre (`name`) VALUES ('Documentary');
INSERT INTO genre (`name`) VALUES ('Drama');
INSERT INTO genre (`name`) VALUES ('Horror');
INSERT INTO genre (`name`) VALUES ('Family');
INSERT INTO genre (`name`) VALUES ('Fantasy');
INSERT INTO genre (`name`) VALUES ('Historical');
INSERT INTO genre (`name`) VALUES ('Musical');
INSERT INTO genre (`name`) VALUES ('Romance');
INSERT INTO genre (`name`) VALUES ('Sport');
INSERT INTO genre (`name`) VALUES ('Science fiction');
INSERT INTO genre (`name`) VALUES ('Thriller');
INSERT INTO genre (`name`) VALUES ('War');
INSERT INTO genre (`name`) VALUES ('Western');

INSERT INTO movie (`imdbId`, `title`, `year`) VALUES ('tt6105098', 'The Lion King', 2019);
INSERT INTO movie (`imdbId`, `title`, `year`) VALUES ('tt4532826', 'Robin Hood', 2018);

INSERT INTO movie_genre (`movie_id_fk`, `genre_id_fk`) VALUES (
  (SELECT `id` FROM `movie` WHERE `title` = 'The Lion King'), 
  (SELECT `id` FROM `genre` WHERE `name` = 'Adventure')
);
INSERT INTO movie_genre (`movie_id_fk`, `genre_id_fk`) VALUES (
  (SELECT `id` FROM `movie` WHERE `title` = 'Robin Hood'), 
  (SELECT `id` FROM `genre` WHERE `name` = 'Animation')
);