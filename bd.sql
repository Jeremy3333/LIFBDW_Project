DROP TABLE IF EXISTS Fonde;
DROP TABLE IF EXISTS Albums_Studio;
DROP TABLE IF EXISTS Albums_Compilation;
DROP TABLE IF EXISTS Compose;
DROP TABLE IF EXISTS Inclut;
DROP TABLE IF EXISTS Repris;
DROP TABLE IF EXISTS Possède;
DROP TABLE IF EXISTS Situé;
DROP TABLE IF EXISTS InvitéMusiciens;
DROP TABLE IF EXISTS Caractérise;
DROP TABLE IF EXISTS Relation;
DROP TABLE IF EXISTS Comporte;
DROP TABLE IF EXISTS Enregistré;
DROP TABLE IF EXISTS InvitéGroupeMusique;
DROP TABLE IF EXISTS Genres;
DROP TABLE IF EXISTS Albums_Lives;
DROP TABLE IF EXISTS Lieux;
DROP TABLE IF EXISTS Musiciens;
DROP TABLE IF EXISTS Listes_de_lecture;
DROP TABLE IF EXISTS VersionsMusique;
DROP TABLE IF EXISTS Albums;
DROP TABLE IF EXISTS Chansons;
DROP TABLE IF EXISTS GroupeMusique;

CREATE TABLE GroupeMusique(
   idGM BIGINT NOT NULL AUTO_INCREMENT,
   Nom VARCHAR(128),
   DateFormation DATE,
   DateSéparation DATE,
   PRIMARY KEY(idGM)
);

CREATE TABLE Chansons(
   idC BIGINT NOT NULL AUTO_INCREMENT,
   idGM BIGINT NOT NULL,
   Titre VARCHAR(128),
   DateCréation DATE,
   PRIMARY KEY (idC),
   FOREIGN KEY (idGM) REFERENCES GroupeMusique(idGM)
);

CREATE TABLE Musiciens(
   idM BIGINT NOT NULL AUTO_INCREMENT,
   Nom VARCHAR(50),
   Prénom VARCHAR(50),
   NomScène VARCHAR(50),
   PRIMARY KEY(idM)
);

CREATE TABLE VersionsMusique(
   idC BIGINT,
   idV BIGINT NOT NULL,
   Forme VARCHAR(50),
   Durée TIME,
   Fichier VARCHAR(500),
   PRIMARY KEY(idC, idV),
   FOREIGN KEY(idC) REFERENCES Chansons(idC)
);

CREATE TABLE Listes_de_lecture(
   idLL BIGINT NOT NULL AUTO_INCREMENT,
   Titre VARCHAR(50),
   DateCréation DATE,
   PRIMARY KEY(idLL)
);

CREATE TABLE Albums(
   idA BIGINT NOT NULL AUTO_INCREMENT,
   Titre VARCHAR(128),
   DateSortie DATE,
   Producteur VARCHAR(50),
   PRIMARY KEY(idA)
);

CREATE TABLE Lieux(
   idL BIGINT,
   Nom VARCHAR(50),
   Coordonnées VARCHAR(50),
   PRIMARY KEY(idL)
);

CREATE TABLE Albums_Studio(
   idA BIGINT,
   IngénieurSon VARCHAR(50),
   PRIMARY KEY(idA),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE Albums_Lives(
   idA BIGINT,
   PRIMARY KEY(idA),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE Albums_Compilation(
   idA BIGINT,
   Description VARCHAR(50),
   PRIMARY KEY(idA),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE Genres(
   idG BIGINT NOT NULL AUTO_INCREMENT,
   Genre VARCHAR(50),
   idG_1 BIGINT,
   PRIMARY KEY(idG),
   FOREIGN KEY(idG_1) REFERENCES Genres(idG)
);

CREATE TABLE Compose(
   idGM BIGINT NOT NULL,
   idM BIGINT,
   DateDébut DATE,
   DateFin DATE,
   Metier VARCHAR(50),
   PRIMARY KEY(idGM, idM, DateDébut, DateFin),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM),
   FOREIGN KEY(idM) REFERENCES Musiciens(idM)
);

CREATE TABLE Inclut(
   idC BIGINT,
   idV BIGINT,
   idLL BIGINT,
   PRIMARY KEY(idC, idV, idLL),
   FOREIGN KEY(idC, idV) REFERENCES VersionsMusique(idC, idV),
   FOREIGN KEY(idLL) REFERENCES Listes_de_lecture(idLL)
);

CREATE TABLE Repris(
   idGM BIGINT,
   idC BIGINT,
   idV BIGINT,
   PRIMARY KEY(idGM, idC, idV),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM),
   FOREIGN KEY(idC, idV) REFERENCES VersionsMusique(idC, idV)
);

CREATE TABLE Possède(
   idC BIGINT NOT NULL,
   idV BIGINT NOT NULL,
   idA BIGINT NOT NULL,
   NuméroPiste BIGINT,
   PRIMARY KEY(idC, idV, idA),
   FOREIGN KEY(idC, idV) REFERENCES VersionsMusique(idC, idV),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE Situé(
   idL BIGINT,
   DateConcert DATE,
   idA BIGINT,
   PRIMARY KEY(idL, DateConcert, idA),
   FOREIGN KEY(idL) REFERENCES Lieux(idL),
   FOREIGN KEY(idA) REFERENCES Albums_Lives(idA)
);

CREATE TABLE InvitéMusiciens(
   idM BIGINT,
   idA BIGINT,
   Commentaire VARCHAR(50),
   PRIMARY KEY(idM, idA),
   FOREIGN KEY(idM) REFERENCES Musiciens(idM),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE Caractérise(
   idC BIGINT,
   idG BIGINT,
   PRIMARY KEY(idC, idG),
   FOREIGN KEY(idC) REFERENCES Chansons(idC),
   FOREIGN KEY(idG) REFERENCES Genres(idG)
);

CREATE TABLE Relation(
   idC BIGINT,
   Type VARCHAR(50),
   idC_1 BIGINT NOT NULL,
   PRIMARY KEY(idC),
   FOREIGN KEY(idC) REFERENCES Chansons(idC),
   FOREIGN KEY(idC_1) REFERENCES Chansons(idC)
);

CREATE TABLE Comporte(
   idC BIGINT,
   idV BIGINT,
   Libellé VARCHAR(50),
   Valeur BIGINT NOT NULL,
   PRIMARY KEY(idC, idV, Libellé),
   FOREIGN KEY(idC, idV) REFERENCES VersionsMusique(idC, idV)
);

CREATE TABLE Enregistré(
   idGM BIGINT,
   idA BIGINT,
   PRIMARY KEY(idGM, idA),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE InvitéGroupeMusique(
   idGM BIGINT,
   idA BIGINT,
   Commentaire VARCHAR(50),
   PRIMARY KEY(idGM, idA),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM),
   FOREIGN KEY(idA) REFERENCES Albums(idA)
);

CREATE TABLE Fonde(
   idGM BIGINT,
   idM BIGINT,
   PRIMARY KEY(idGM, idM),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM),
   FOREIGN KEY(idM) REFERENCES Musiciens(idM)
);

-- INSERT INTO GroupeMusique VALUES(1, 'Junkerito', '1900-01-01', '2013-06-25');
-- INSERT INTO GroupeMusique VALUES(2, 'Prrrrt', '1925-12-30', '2013-06-25');
-- INSERT INTO Musiciens VALUES(1, 'Grënbe', 'Julio', 'Ninjart');
-- INSERT INTO Musiciens VALUES(2, 'Varex', 'Erwan', 'Ninjart');
-- INSERT INTO Chansons VALUES(1, 1, 'Hector Dupuisse', '1925-12-30');
-- INSERT INTO Genres VALUES(1, "Junkeroulade", NULL);
-- INSERT INTO Genres VALUES(2, "full", 1);
-- INSERT INTO VersionsMusique VALUES(1, 1, 'version original', '03:20:00.000000', 'hector_dupuisse_original.mp3');
-- INSERT INTO VersionsMusique VALUES(1, 2, 'version live', '04:12:00.000000', 'hector_dupuisse_bercy2001.mp3');
-- INSERT INTO VersionsMusique VALUES(1, 3, 'version remix', '02:47:00.000000', 'hector_dupuisse_remixPrrrt.mp3');
-- INSERT INTO Listes_de_lecture VALUES(1, 'Les 10 titres triple diamant de Jukerito', '2013-06-25');
-- INSERT INTO Albums VALUES(1, 'People de toi', '1927-07-14', 'Jean-Jacques Shiraky');
-- INSERT INTO Albums VALUES(2, 'Je sais pas', '1978-02-26', 'Jean-Jacques Shirako');
-- INSERT INTO Albums VALUES(3, 'Ptdr t ki', '1789-08-14', 'Robespierre');
-- INSERT INTO Listes_de_lecture VALUES(1, 'Les 10 titres triple diamant de Jukerito', '2013-06-25');
-- INSERT INTO Albums VALUES(1, 'People de toi', '1927-07-14', 'Jean-Jacques Shiraky');
-- INSERT INTO Albums VALUES(2, 'Je sais pas', '1978-02-26', 'Jean-Jacques Shirako');
-- INSERT INTO Albums VALUES(3, 'Ptdr t ki', '1989-08-14', 'Robespierre');
-- INSERT INTO Albums_Studio VALUES(1, 'Pablo Pablo-Pablo');
-- INSERT INTO Albums_Compilation VALUES (2, "Il s'agit de toutes les featuring de Junkerito");
-- INSERT INTO Albums_Lives VALUES(3);
-- INSERT INTO Lieux VALUES(1, 'Phobos', 'Mars');
-- INSERT INTO Situé VALUES(1, '1978-02-26', 3);
-- INSERT INTO Compose VALUES(1, 1, '1927-07-14', '2013-06-26', TRUE, 'Bassiste');
-- INSERT INTO Possède VALUES(1, 1, 1, 1);
-- INSERT INTO InvitéMusiciens VALUES(2, 1, 'Groupe très gentil');
-- INSERT INTO InvitéGroupeMusique VALUES(2, 1, 'Spectaculaire !');
-- INSERT INTO Relation VALUES(1, 'Suite', 1);
-- INSERT INTO Comporte VALUES(1, 1 , 'Nombre de notes', 100);
-- INSERT INTO Inclut VALUES(1, 1, 1);
-- INSERT INTO Caractérise VALUES(1, 1);
-- INSERT INTO Enregistré VALUES(1, 1);