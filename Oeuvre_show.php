<?php
	include("connexion_bdd.php");
	$requete =  "SELECT AUTEUR.nomAuteur,OEUVRE.titre,OEUVRE.dateParution FROM OEUVRE
				 INNER JOIN AUTEUR ON OEUVRE.idAuteur = AUTEUR.idAuteur
				 ORDER BY OEUVRE.titre;"
	// auteur titre date parution nbr nbrDispo operations
?>
