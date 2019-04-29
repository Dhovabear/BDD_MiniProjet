<?php
	include("connexion_bdd.php");
	// auteur titre date parution nbr nbrDispo operations

	$commande = "SELECT AUTEUR.nomAuteur , OEUVRE.titre , OEUVRE.dateParution FROM OEUVRE
					INNER JOIN AUTEUR ON OEUVRE.idAuteur = AUTEUR.idAuteur";
	$oeuvre = $bdd->query($commande)->fetchAll();

?>

<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>


<div class="row">
	<div class="titreMenu">Affichage des oeuvres</div>
	<table border="2">
		<caption>Liste des Oeuvres</caption>
		<thead>
		<tr><th>Nom de l'auteur</th><th>Titre de l'oeuvre </th><th>Date de parution</th><th>actions</th></tr>
		</thead>
		<tbody>
        <?php foreach ($oeuvre as $ligne ): ?>
			<tr>
				<td><?php echo($ligne["nomAuteur"]); ?></td>
				<td><?php echo($ligne["titre"]); ?></td>
				<td><?php echo($ligne["dateParution"]); ?></td>
				<td>
					<a href="Auteur_delete.php?idToDel=<?php echo($ligne["idAuteur"]) ?>">Supprimer</a>
					<a href="Auteur_edit.php?idToEdit=<?php echo($ligne["idAuteur"]) ?>">Modifier</a>
				</td>
			</tr>
        <?php endforeach; ?>
		</tbody>
	</table>

</div>


<?php include ("v_foot.php");  ?>
