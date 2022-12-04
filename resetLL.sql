DROP TABLE IF EXISTS Inclut;
DROP TABLE IF EXISTS Listes_de_lecture;

CREATE TABLE Listes_de_lecture(
   idLL BIGINT NOT NULL AUTO_INCREMENT,
   Titre VARCHAR(50),
   DateCréation DATE,
   PRIMARY KEY(idLL)
);

CREATE TABLE Inclut(
   idC BIGINT,
   idV BIGINT,
   idLL BIGINT,
   PRIMARY KEY(idC, idV, idLL),
   FOREIGN KEY(idC, idV) REFERENCES VersionsMusique(idC, idV),
   FOREIGN KEY(idLL) REFERENCES Listes_de_lecture(idLL)
);