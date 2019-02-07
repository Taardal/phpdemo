CREATE DATABASE IF NOT EXISTS svitts;
USE svitts;

DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` VARCHAR(255) NOT NULL UNIQUE,
  `title` VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  PRIMARY KEY(`id`)
);

INSERT INTO movie (`id`, `title`, `year`) VALUES ('tt6105098', 'The Lion King', 2019);
INSERT INTO movie (`id`, `title`, `year`) VALUES ('tt4532826', 'Robin Hood', 2018);