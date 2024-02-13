CREATE TABLE IF NOT EXISTS Editeur
(
	ID          INT(11) PRIMARY KEY AUTO_INCREMENT,
	Nom_Editeur VARCHAR(25)
);
CREATE TABLE IF NOT EXISTS Jeu
(
	ID             INT(11) PRIMARY KEY AUTO_INCREMENT,
	Nom_jeu        VARCHAR(100),
	Editeur_jeu    INT(11),
	Difficulte_jeu INT(11),
	FOREIGN KEY (Editeur_jeu) REFERENCES Editeur(ID)
);


