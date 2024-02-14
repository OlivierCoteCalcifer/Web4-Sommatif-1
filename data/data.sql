DROP DATABASE IF EXISTS `database`;
CREATE DATABASE `database`;
USE `database`;

DROP TABLE IF EXISTS jeu;
DROP TABLE IF EXISTS editeur;

CREATE TABLE editeur
(
	`id`          INT(11) AUTO_INCREMENT PRIMARY KEY,
	`nom_editeur` VARCHAR(25) NOT NULL
);

CREATE TABLE jeu
(
	`id`             INT(11) AUTO_INCREMENT PRIMARY KEY,
	`nom_jeu`        VARCHAR(100) NOT NULL,
	`editeur_jeu`    INT(11)      NOT NULL,
	`difficulte_jeu` INT(11)      NOT NULL,
	CONSTRAINT fk_jeu_editeur FOREIGN KEY (editeur_jeu) REFERENCES editeur (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
