
DROP TABLE IF EXISTS EMPRUNT , EXEMPLAIRE , OEUVRE , date , AUTEUR , ADHERENT;


#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: ADHERENT
#------------------------------------------------------------

CREATE TABLE ADHERENT(
        idAdherent   Int  Auto_increment  NOT NULL ,
        nomAdherent  Varchar (255) ,
        adresse      Varchar (255) ,
        datePaiement Date
	,CONSTRAINT ADHERENT_PK PRIMARY KEY (idAdherent)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: AUTEUR
#------------------------------------------------------------

CREATE TABLE AUTEUR(
        idAuteur     Int  Auto_increment  NOT NULL ,
        nomAuteur    Varchar (255) ,
        prenomAuteur Varchar (255)
	,CONSTRAINT AUTEUR_PK PRIMARY KEY (idAuteur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: date
#------------------------------------------------------------

CREATE TABLE date(
        dateEmprunt Date NOT NULL
	,CONSTRAINT date_PK PRIMARY KEY (dateEmprunt)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: OEUVRE
#------------------------------------------------------------

CREATE TABLE OEUVRE(
        noOeuvre     Int  Auto_increment  NOT NULL ,
        titre        Varchar (255) ,
        dateParution Date ,
        idAuteur     Int NOT NULL
	,CONSTRAINT OEUVRE_PK PRIMARY KEY (noOeuvre)

	,CONSTRAINT OEUVRE_AUTEUR_FK FOREIGN KEY (idAuteur) REFERENCES AUTEUR(idAuteur) ON DELETE CASCADE
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: EXEMPLAIRE
#------------------------------------------------------------

CREATE TABLE EXEMPLAIRE(
        noExemplaire Int  Auto_increment  NOT NULL ,
        etat         Varchar (255) ,
        dateAchat    Date ,
        prix         Decimal (8,2) ,
        noOeuvre     Int NOT NULL
	,CONSTRAINT EXEMPLAIRE_PK PRIMARY KEY (noExemplaire)

	,CONSTRAINT EXEMPLAIRE_OEUVRE_FK FOREIGN KEY (noOeuvre) REFERENCES OEUVRE(noOeuvre) ON DELETE CASCADE
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: EMPRUNT
#------------------------------------------------------------

CREATE TABLE EMPRUNT(
        idAdherent   Int NOT NULL ,
        noExemplaire Int NOT NULL ,
        dateEmprunt  Date NOT NULL ,
        dateRendu    Date
	,CONSTRAINT EMPRUNT_PK PRIMARY KEY (idAdherent,dateEmprunt,noExemplaire)

	,CONSTRAINT EMPRUNT_ADHERENT_FK FOREIGN KEY (idAdherent) REFERENCES ADHERENT(idAdherent) ON DELETE CASCADE
	,CONSTRAINT EMPRUNT_EXEMPLAIRE1_FK FOREIGN KEY (noExemplaire) REFERENCES EXEMPLAIRE(noExemplaire) ON DELETE CASCADE
)ENGINE=InnoDB;