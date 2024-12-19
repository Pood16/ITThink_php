-- Craetion de database
CREATE DATABASE ITThink;
USE ITThink;
-- Creation des tables 
-- table d'utilisateurs
CREATE TABLE utilisateurs(
	id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom_utilisateur VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(128) NOT NULL,
    email VARCHAR(50),
    phone VARCHAR(10)
);
DROP TABLE utilisateurs;
#table categorie
CREATE TABLE categories(
	id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(50) NOT NULL
);
-- table sous_categories
CREATE TABLE sousCategories(
	id_sous_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_sous_categorie VARCHAR(50) NOT NULL,
    id_categorie INT,
    FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie)
);
#projects table
CREATE TABLE projects(
	id_project INT AUTO_INCREMENT PRIMARY KEY,
    titre_projet VARCHAR(50) NOT NULL,
    description_projet VARCHAR(300),
    id_categorie INT,
    FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie),
    id_sous_categorie INT,
    FOREIGN KEY (id_sous_categorie) REFERENCES sousCategories(id_sous_categorie),
    id_utilisateur INT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);
ALTER TABLE projects
ADD projet_status VARCHAR(30) DEFAULT "Encours";
#freelances table 
CREATE TABLE freelances(
	id_freelance INT PRIMARY KEY AUTO_INCREMENT,
    nom_freelance VARCHAR(50) NOT NULL,
    competences VARCHAR(400) NOT NULL,
    id_utilisateur INT, 
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);
CREATE TABLE offres(
	id_offre INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10, 2) NOT NULL,
    delai DATETIME NOT NULL, 
    id_freelance INT,
    FOREIGN KEY (id_freelance) REFERENCES freelances(id_freelance),
    id_project INT,
    FOREIGN KEY (id_project) REFERENCES projects(id_project)
);
-- temoignage table
CREATE TABLE temoignage(
	id_temoignage INT AUTO_INCREMENT PRIMARY KEY,
    commentaire VARCHAR(400) NOT NULL,
    id_utilisateur INT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);
-- ajouter un colonne dans un tableau
ALTER TABLE projects
ADD date_creation DATETIME;
# ADD content to tables
-- utilisateurs table
INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, email, phone)
VALUES ("ouirghane", "motDePasse", "gmail@gmail.com", "0622434965"),
	   ("anas", "motDePasseY", "anass@gmail.com", "0622434785");
-- categories table
INSERT INTO categories(nom_categorie)
VALUES ("WEB DEVELOPMENT"),("DESIGN");
-- sous-categories
INSERT INTO sousCategories(nom_sous_categorie, id_categorie)
VALUES ("sous categorie 1", 2),
	   ("sous categorie 2", 1);
-- projects table
INSERT INTO projects(titre_projet, description_projet, id_categorie, id_sous_categorie, id_utilisateur, date_creation)
VALUES ("Portfolio", "simple portfolio to show my work and projects", 2,1, 2, "2024-12-29 15:22:10");
-- freelances table
INSERT INTO freelances (nom_freelance, competences, id_utilisateur)
VALUES ("Pood", "javascript css html5", 2);
-- offre table
INSERT INTO offres(montant, delai, id_freelance, id_project)
VALUES (29.8, "2024-12-28 14:25:40", 3, 1);
-- temouignage table 
INSERT INTO temoignage (commentaire, id_utilisateur)
VALUES ("Le travail n'est pas bien realiser alors je donne 2 etoiles", 3);
-- update a project details
UPDATE projects
SET titre_projet = "Balzac application"
WHERE id_project = 1;
-- delete temoignage
DELETE FROM temoignage
WHERE id_temoignage = 1;
-- ajouter des temoignages
INSERT INTO temoignage (commentaire, id_utilisateur)
VALUES ("Le projet est bien realiser", 3),	
	   ("Il n'a pas respecter Mes besoins, mauvaise experience", 2),
       ("Tres bon travail, Je recommande ce profile", 1);
-- inner join
SELECT * FROM projects
JOIN categories
ON projects.id_project = categories.id_categorie;

SELECT * FROM utilisateurs;
SELECT * FROM categories;
SELECT * FROM sousCategories;
SELECT * FROM freelances;
SELECT * FROM offres;
SELECT * FROM projects;
SELECT * FROM temoignage;

