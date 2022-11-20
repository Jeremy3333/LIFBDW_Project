

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
DROP TABLE IF EXISTS Periodes;
DROP TABLE IF EXISTS Musiciens;
DROP TABLE IF EXISTS Listes_de_lecture;
DROP TABLE IF EXISTS VersionsMusique;
DROP TABLE IF EXISTS Albums;
DROP TABLE IF EXISTS Chansons;
DROP TABLE IF EXISTS GroupeMusique;

CREATE TABLE GroupeMusique(
   idGM BIGINT,
   Nom VARCHAR(50),
   DateFormation DATE,
   DateSéparaton DATE,
   PRIMARY KEY(idGM)
);

CREATE TABLE Chansons(
   idGM BIGINT,
   idC BIGINT,
   Titre VARCHAR(50),
   DateCréation DATE,
   PRIMARY KEY(idGM, idC),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM)
);

CREATE TABLE Musiciens(
   idM BIGINT,
   Nom VARCHAR(50),
   Prénom VARCHAR(50),
   NomScène VARCHAR(50),
   PRIMARY KEY(idM)
);

CREATE TABLE VersionsMusique(
   idGM BIGINT,
   idC BIGINT,
   idV BIGINT,
   Forme VARCHAR(50),
   Durée TIME,
   Nom VARCHAR(50),
   PRIMARY KEY(idGM, idC, idV),
   FOREIGN KEY(idGM, idC) REFERENCES Chansons(idGM, idC)
);

CREATE TABLE Listes_de_lecture(
   idLL BIGINT,
   Titre VARCHAR(50),
   DateCréation DATE,
   PRIMARY KEY(idLL)
);

CREATE TABLE Albums(
   idA BIGINT,
   Titre VARCHAR(50),
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
   idG BIGINT,
   Genre VARCHAR(50),
   idG_1 BIGINT,
   PRIMARY KEY(idG),
   FOREIGN KEY(idG_1) REFERENCES Genres(idG)
);

CREATE TABLE Periodes(
   DateDébut DATE,
   DateFin DATE,
   PRIMARY KEY(DateDébut, DateFin)
);

CREATE TABLE Compose(
   idGM BIGINT,
   idM BIGINT,
   DateDébut DATE,
   DateFin DATE,
   Fondateur VARCHAR(50),
   Metier VARCHAR(50),
   PRIMARY KEY(idGM, idM, DateDébut, DateFin),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM),
   FOREIGN KEY(idM) REFERENCES Musiciens(idM),
   FOREIGN KEY(DateDébut, DateFin) REFERENCES Periodes(DateDébut, DateFin)
);

CREATE TABLE Inclut(
   idGM BIGINT,
   idC BIGINT,
   idV BIGINT,
   idLL BIGINT,
   PRIMARY KEY(idGM, idC, idV, idLL),
   FOREIGN KEY(idGM, idC, idV) REFERENCES VersionsMusique(idGM, idC, idV),
   FOREIGN KEY(idLL) REFERENCES Listes_de_lecture(idLL)
);

CREATE TABLE Repris(
   idGM BIGINT,
   idGM_1 BIGINT,
   idC BIGINT,
   idV BIGINT,
   PRIMARY KEY(idGM, idGM_1, idC, idV),
   FOREIGN KEY(idGM) REFERENCES GroupeMusique(idGM)
);

CREATE TABLE Possède(
   idGM BIGINT,
   idC BIGINT,
   idV BIGINT,
   idA BIGINT,
   NuméroPiste BIGINT,
   PRIMARY KEY(idGM, idC, idV, idA),
   FOREIGN KEY(idGM, idC, idV) REFERENCES VersionsMusique(idGM, idC, idV),
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
   idGM BIGINT,
   idC BIGINT,
   idG BIGINT,
   PRIMARY KEY(idGM, idC, idG),
   FOREIGN KEY(idGM, idC) REFERENCES Chansons(idGM, idC),
   FOREIGN KEY(idG) REFERENCES Genres(idG)
);

CREATE TABLE Relation(
   idGM BIGINT,
   idC BIGINT,
   Type VARCHAR(50),
   idGM_1 BIGINT NOT NULL,
   idC_1 BIGINT NOT NULL,
   PRIMARY KEY(idGM, idC),
   FOREIGN KEY(idGM, idC) REFERENCES Chansons(idGM, idC),
   FOREIGN KEY(idGM_1, idC_1) REFERENCES Chansons(idGM, idC)
);

CREATE TABLE Comporte(
   idGM BIGINT,
   idC BIGINT,
   idV BIGINT,
   Libellé VARCHAR(50),
   Valeur BIGINT NOT NULL,
   PRIMARY KEY(idGM, idC, idV, Libellé),
   FOREIGN KEY(idGM, idC, idV) REFERENCES VersionsMusique(idGM, idC, idV)
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

-- INSERT INTO GroupeMusique VALUES(1,'Junkerito',1779,2013);
-- INSERT INTO GroupeMusique VALUES(2,'Prrrrt',1779,2013);
-- INSERT INTO Musiciens VALUES(1,'Grënbe','Julio','Ninjart');
-- INSERT INTO Musiciens VALUES(2,'Varex','Erwan','Ninjart');
-- INSERT INTO Chansons VALUES(1,1,'Hector Dupuisse',1927);
-- INSERT INTO Genres VALUES(1,"Junkeroulade");
-- INSERT INTO VersionsMusique VALUES(1,1,1,'version original',3:20,'hector_dupuisse_original.mp3');
-- INSERT INTO Listes_de_lecture VALUES(1,'Les 10 titres triple diamant de Jukerito',2013);
-- INSERT INTO Album VALUES(1,'People de toi',1927,'Jean-Jacques Shiraky');
-- INSERT INTO Album VALUES(2,'Je sais pas',1827,'Jean-Jacques Shirako');
-- INSERT INTO Album VALUES(3,'Ptdr t ki',1789,'Robespierre');
-- INSERT INTO Albums_Studio VALUES(1,'Pablo Pablo-Pablo');
-- INSERT INTO Albums_Compilation VALUES (2,"Il s'agit de toutes les featuring de Junkerito");
-- INSERT INTO Album_Lives VALUES(3);
-- INSERT INTO Lieu VALUES(1,'Phobos','Mars');
-- INSERT INTO Situé VALUES(1,1974,1);
-- INSERT INTO Compose VALUES(1,1,1779,2013,true,'Bassiste');
-- INSERT INTO Possède VALUES(1,1,1,1,1);
-- INSERT INTO InvitéMusiciens VALUES(2,1,'Groupe très gentil');
-- INSERT INTO InvitéGroupeMusique VALUES(2,1,'Spectaculaire !');
-- INSERT INTO Relation(1,1);
-- INSERT INTO Comporte VALUES(1,1,1);
-- INSERT INTO Inclut VALUES(1,1,1,1);
-- INSERT INTO Repris VALUES(1,1,1,1);
-- INSERT INTO Caractérise VALUES(1,1,1);
-- INSERT INTO Enregistré VALUES(1,1);
