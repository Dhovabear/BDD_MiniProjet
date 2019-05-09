<?php
	include("connexion_bdd.php");
	// auteur titre date parution nbr nbrDispo operations

    $smthgWasDel = false;
    $smthgWasAdd = false;
    $smthgWasEdit = false;

    if(isset($_GET)){
        if(isset($_GET["delSuc"])){
            $smthgWasDel = true;
        }
        if(isset($_GET["addSuc"])){
            $smthgWasAdd = true;
        }
        if(isset($_GET["editSuc"])){
            $smthgWasEdit = true;
        }
    }

	$commande2 = "SELECT AUTEUR.nomAuteur, OEUVRE.titre, OEUVRE.noOeuvre, OEUVRE.dateParution
	              , COUNT(E1.noExemplaire) AS nbr
	              , COUNT(E2.noexemplaire) AS restant
	              FROM OEUVRE
	              JOIN AUTEUR ON AUTEUR.idAuteur = OEUVRE.idAuteur
	              LEFT JOIN EXEMPLAIRE E1 ON E1.noOeuvre = OEUVRE.noOeuvre
	              LEFT JOIN EXEMPLAIRE E2 ON E2.noExemplaire = E1.noExemplaire
	                  AND E2.noExemplaire NOT IN (SELECT EMPRUNT.noExemplaire FROM EMPRUNT WHERE EMPRUNT.dateRendu IS NULL)
	              GROUP BY OEUVRE.noOeuvre
	              ORDER BY AUTEUR.nomAuteur ASC, OEUVRE.titre ASC;";

	$oeuvre = $bdd->query($commande2)->fetchAll();

?>

<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>


<div class="row">
	<div class="titreMenu">Affichage des oeuvres</div>
    <?php if($smthgWasDel): ?>
        <?php if($_GET["delSuc"] == 0): ?>
            <div class="titreMenu" style="color: red">Une erreur est survenu lors de la suppression de l'oeuvre.</div>
        <?php else: ?>
            <div class="titreMenu" style="color: green"> Suppression réussie !</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($smthgWasAdd): ?>
        <?php if($_GET["addSuc"] == 0): ?>
            <div class="titreMenu" style="color: red">Une erreur est survenu lors de l'ajout de l'oeuvre.</div>
        <?php else: ?>
            <div class="titreMenu" style="color: green"> Ajout réussie !</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($smthgWasEdit): ?>
        <?php if($_GET["editSuc"] == 0): ?>
            <div class="titreMenu" style="color: red">Une erreur est survenu lors de la modification de l'oeuvre.</div>
        <?php else: ?>
            <div class="titreMenu" style="color: green"> Modification réussie !</div>
        <?php endif; ?>
    <?php endif; ?>

    <a href="Oeuvre_add.php">Ajouter une oeuvre</a>

    <?php if(isset($oeuvre[0])): ?>
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
                    <td><a href="Exemplaire_show.php?noOeuvre=<?php echo($ligne["noOeuvre"])?>">Gerer les exemplaires</a></td>
                    <td>
                        <a href="Oeuvre_delete.php?idToDel=<?php echo($ligne["noOeuvre"]) ?>&nbr=<?php echo($ligne["nbr"]) ?>">Supprimer</a>
                        <a href="Oeuvre_edit.php?idToEdit=<?php echo($ligne["noOeuvre"]) ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="titreMenu">Aucune Oeuvre enregistrée dans la base de donnés</div>
    <?php endif;?>


</div>


<?php include ("v_foot.php");  ?>
