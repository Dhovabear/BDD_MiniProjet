

LOAD DATA LOCAL INFILE 'DonnesCSV/ADHERENT.csv' INTO TABLE ADHERENT CHARACTER SET utf8 FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'DonnesCSV/AUTEUR.csv' INTO TABLE AUTEUR CHARACTER SET utf8 FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'DonnesCSV/OEUVRE.csv' INTO TABLE OEUVRE CHARACTER SET utf8 FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'DonnesCSV/EXEMPLAIRE.csv' INTO TABLE EXEMPLAIRE CHARACTER SET utf8 FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'DonnesCSV/EMPRUNT.csv' INTO TABLE EMPRUNT CHARACTER SET utf8 FIELDS TERMINATED BY ',';
