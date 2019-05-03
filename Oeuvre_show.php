<?php
	include("connexion_bdd.php");
	// auteur titre date parution nbr nbrDispo operations

	$commande = "SELECT OEUVRE.noOeuvre , AUTEUR.idAuteur, AUTEUR.nomAuteur , OEUVRE.titre ,
                        OEUVRE.dateParution , COUNT(EXEMPLAIRE.noOeuvre) AS nbr,
                        (COUNT(EXEMPLAIRE.noOeuvre) - COUNT(EMPRUNT.noExemplaire)) AS restant  FROM OEUVRE
					INNER JOIN AUTEUR ON OEUVRE.idAuteur = AUTEUR.idAuteur
					LEFT JOIN EXEMPLAIRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
					LEFT JOIN EMPRUNT ON EXEMPLAIRE.noExemplaire = EMPRUNT.noExemplaire
					GROUP BY OEUVRE.noOeuvre;";
	$oeuvre = $bdd->query($commande)->fetchAll();

?>

<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>


<div class="row">
	<div class="titreMenu">Affichage des oeuvres</div>
	<table border="2">
		<caption>Liste des Oeuvres</caption>
		<thead>
		<tr><th>Nom de l'auteur</th><th>Titre de l'oeuvre </th>
            <th>Date de parution</th><th>Nombre d'exemplaires</th>
            <th>Nombre disponibles</th><th>Exemplaires</th>
            <th>actions</th></tr>
		</thead>
		<tbody>
        <?php foreach ($oeuvre as $ligne ): ?>
			<tr>
				<td><?php echo($ligne["nomAuteur"]); ?></td>
				<td><?php echo($ligne["titre"]); ?></td>
				<td><?php echo($ligne["dateParution"]); ?></td>
                <td><?php echo($ligne["nbr"]); ?></td>
                <td><?php echo($ligne["restant"]); ?></td>
                <td><a href="https://submeg.files.wordpress.com/2011/12/work-in-progress22.jpg?w=620&h=521&crop=1">Gerer les exemplaires</a></td>
				<td>
					<a href="Oeuvre_delete.php?idToDel=<?php echo($ligne["noOeuvre"]) ?>">Supprimer</a>
					<a href="Oeuvre_edit.php?idToEdit=<?php echo($ligne["noOeuvre"]) ?>">Modifier</a>
				</td>
			</tr>
        <?php endforeach; ?>
		</tbody>
	</table>

</div>


<?php include ("v_foot.php");  ?>
