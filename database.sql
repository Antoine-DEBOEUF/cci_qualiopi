DROP DATABASE IF EXISTS epicerie;
#Premiere bdd
create database epicerie;
#se placer sur cette bdd
use epicerie;

#creation des premieres tables
create table poste(
id int primary key auto_increment,
nom VARCHAR(80) NOT NULL UNIQUE);

CREATE TABLE genre(
id int primary key auto_increment,
nom VARCHAR(80) NOT NULL UNIQUE);

CREATE TABLE rayon(
id int primary key auto_increment,
nom VARCHAR(80) NOT NULL UNIQUE);

CREATE TABLE caisse(
id int primary key auto_increment,
matricule VARCHAR(11) NOT NULL UNIQUE);

CREATE TABLE statut(
id int primary key auto_increment,
nom VARCHAR(50) NOT NULL);

CREATE TABLE personnel(
id int primary key auto_increment,
nom VARCHAR(80) NOT NULL,
prenom VARCHAR(80) NOT NULL,
id_poste INT NOT NULL,
date_naiss DATE NOT NULL,
date_entree DATE DEFAULT (NOW()),
date_sortie DATE,
id_genre INT NOT NULL,
matricule VARCHAR(12) NOT NULL,
id_manager INT);

CREATE TABLE infos_personnel(
id_personnel INT PRIMARY KEY NOT NULL,
tel VARCHAR(11),
mail VARCHAR(150) UNIQUE,
ville VARCHAR(70),
adresse VARCHAR(100),
CP VARCHAR(5),
secu VARCHAR(13) UNIQUE,
iban VARCHAR(34));

CREATE TABLE produit(
id INT PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL,
des TEXT,
prix DECIMAL(10,2) NOT NULL,
id_rayon INT NOT NULL);

CREATE TABLE adherent(
id INT PRIMARY KEY AUTO_INCREMENT,
ncarte VARCHAR(13) NOT NULL,
nom VARCHAR(80) NOT NULL,
prenom VARCHAR(80) NOT NULL,
date_adhesion DATETIME DEFAULT( NOW()));

CREATE TABLE infos_adherent(
id INT PRIMARY KEY,
mail VARCHAR(180),
tel VARCHAR(11),
adresse VARCHAR(180),
CP VARCHAR(5),
id_genre INT NOT NULL);

CREATE TABLE passage_caisse(
id INT PRIMARY KEY AUTO_INCREMENT,
date_passage DATETIME DEFAULT(NOW()),
id_adherent INT NOT NULL,
id_caisse INT NOT NULL,
id_pers INT NOT NULL,
id_statut INT NOT NULL);

CREATE TABLE ticket(
id INT PRIMARY KEY AUTO_INCREMENT,
id_passage_caisse INT NOT NULL,
id_produit INT NOT NULL,
qte INT NOT NULL);