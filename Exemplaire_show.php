<?php
include("connexion_bdd.php");




// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

$numOeuvre = 0;

if(isset($_GET)){
    if(isset($_GET["noOeuvre"])){
        $numOeuvre = $_GET["noOeuvre"];
    }
}


$commande = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noOeuvre = ".$bdd->quote($numOeuvre).";";
$exemplaires = $bdd->query($commande)->fetchAll();

$commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$bdd->quote($numOeuvre).";";
$oeuvre = $bdd->query($commande)->fetch();

$commande = "SELECT EMPRUNT.noExemplaire, EMPRUNT.dateRendu , EXEMPLAIRE.noOeuvre FROM EMPRUNT 
              INNER JOIN EXEMPLAIRE ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
             WHERE EXEMPLAIRE.noOeuvre = ".$oeuvre["noOeuvre"]." ;";
$emprunts = $bdd->query($commande)->fetchAll();

$commande2 = "SELECT AUTEUR.nomAuteur, OEUVRE.titre, OEUVRE.noOeuvre, OEUVRE.dateParution
	              , COUNT(E1.noExemplaire) AS nbr
	              , COUNT(E2.noexemplaire) AS restant
	              FROM OEUVRE
	              JOIN AUTEUR ON AUTEUR.idAuteur = OEUVRE.idAuteur
	              LEFT JOIN EXEMPLAIRE E1 ON E1.noOeuvre = OEUVRE.noOeuvre
	              LEFT JOIN EXEMPLAIRE E2 ON E2.noExemplaire = E1.noExemplaire
	                  AND E2.noExemplaire NOT IN (SELECT EMPRUNT.noExemplaire FROM EMPRUNT WHERE EMPRUNT.dateRendu IS NULL)
	              WHERE AUTEUR.idAuteur = ".$numOeuvre."
	              GROUP BY OEUVRE.noOeuvre
	              ORDER BY AUTEUR.nomAuteur ASC, OEUVRE.titre ASC;";
$exemplairesDispos = $bdd->query($commande2)->fetchAll()[0];

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->


<div class="row">
    <div class="titreMenu">Exemplaires de l'oeuvre '<?php echo($oeuvre["titre"]) ?>' </div>
    <div class="titreMenu">Nombre d'exemplaire(s): <?php echo($exemplairesDispos["nbr"]) ?> ,  Restant(s): <?php echo($exemplairesDispos["restant"]) ?> </div>
    <table border="2">
        <caption>Liste des exemplaires</caption>
        <thead>
            <tr>
                <th>N exemplaire</th><th>etat</th>
                <th>date achat</th><th>prix</th><th>opérations</th>
            </tr>
        </thead>
        <tbody>
        <?php for ( $i = 0 ; $i < count($exemplaires) ; $i++): ?>
                <tr>
                    <td><?php echo($exemplaires[$i]["noExemplaire"]) ?></td>
                    <td><?php echo($exemplaires[$i]["etat"]) ?></td>
                    <td><?php echo($exemplaires[$i]["dateAchat"]) ?></td>
                    <td><?php echo($exemplaires[$i]["prix"]) ?></td>
                    <td>
                        <a href="Exemplaire_edit.php?idToEdit=<?php echo($exemplaires[$i]["noExemplaire"]) ?>">Modifier</a>
                        <a href="Exemplaire_delete.php?idToDel=<?php echo($exemplaires[$i]["noExemplaire"]) ?>">Supprimer</a>
                    </td>
                </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>


<?php include ("v_foot.php");  ?>
