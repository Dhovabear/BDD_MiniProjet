<?php
include("connexion_bdd.php");




// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

$numOeuvre = 0;

$smtWasAdd = false;
$addSuc = 0;

$smtWasDel = false;
$delSuc = 0;

$nbrOeuvr = 0;
if(isset($_GET)){
    if(isset($_GET["noOeuvre"])){
        $numOeuvre = $_GET["noOeuvre"];
    }
    if(isset($_GET["addSuc"])){
         $smtWasAdd = true;
         $addSuc = $_GET["addSuc"];
    }
    if(isset($_GET["delSuc"])){
        $smtWasDel = true;
        $delSuc = $_GET["delSuc"];
    }
}


$commande = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noOeuvre = ".$bdd->quote($numOeuvre).";";
$exemplaires = $bdd->query($commande)->fetchAll();

$commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$bdd->quote($numOeuvre).";";
$oeuvre = $bdd->query($commande)->fetch();

$commande = "SELECT OEUVRE.noOeuvre,
                   COUNT(EXEMPLAIRE.noExemplaire)AS nbr
            FROM EXEMPLAIRE
            INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
            WHERE OEUVRE.noOeuvre = ".$numOeuvre."
            GROUP BY OEUVRE.noOeuvre;";
$oeuvrInfo = $bdd->query($commande)->fetch();



foreach ($exemplaires as $ligne){
    $commande = "SELECT EXEMPLAIRE.noExemplaire NOT IN(SELECT EMPRUNT.noExemplaire FROM EMPRUNT WHERE EMPRUNT.dateRendu = '0000-00-00' OR EMPRUNT.dateRendu IS NULL) AS dispo FROM EXEMPLAIRE
                                 INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
                                 WHERE OEUVRE.noOeuvre = ".$numOeuvre." AND EXEMPLAIRE.noExemplaire = ".$ligne["noExemplaire"].";";
    $res = $bdd->query($commande)->fetch();
    if($res["dispo"]){
        $nbrOeuvr++;
    }
}


// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->


<div class="row">
    <div class="titreMenu">Exemplaires de l'oeuvre '<?php echo($oeuvre["titre"]) ?>' </div>
    <div class="titreMenu">Nombre d'exemplaire(s): <?php echo($oeuvrInfo["nbr"]) ?> ,  Restant(s): <?php echo $nbrOeuvr ?> </div>

    <br>
    <a href="Oeuvre_show.php">Retour</a><br>
    <br>
    <a href="Exemplaire_add.php?idOeuvre=<?php echo($numOeuvre) ?>">Ajouter un exemplaire</a>
    <?php if($smtWasAdd): ?>
            <?php if($addSuc == 1): ?>
                    <div class="alert" style="color: green">Ajout réussit !</div>
            <?php else: ?>
                    <div class="erreur" style="color:red;">Erreur lors de l'ajout!</div>
            <?php endif; ?>
            <div class="alert" style="color:green"></div>
    <?php endif; ?>
    <?php if($smtWasDel): ?>
        <?php if($delSuc == 1): ?>
            <div class="alert" style="color: green">Suppression réussie !</div>
        <?php else: ?>
            <div class="erreur" style="color:red;">Erreur lors de la suppression!</div>
        <?php endif; ?>
        <div class="alert" style="color:green"></div>
    <?php endif; ?>

    <?php if(isset($exemplaires[0])): ?>
    <table border="2">
        <caption>Liste des exemplaires</caption>
        <thead>
        <tr>
            <th>N exemplaire</th><th>etat</th>
            <th>date achat</th><th>prix</th><th>opérations</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($exemplaires as $ligne): ?>
                <?php
        $style = "";
        $isDispo = "(indisponible) ";
        $commande = "SELECT EXEMPLAIRE.noExemplaire NOT IN(SELECT EMPRUNT.noExemplaire FROM EMPRUNT WHERE EMPRUNT.dateRendu = '0000-00-00' OR EMPRUNT.dateRendu IS NULL) AS dispo FROM EXEMPLAIRE
                                 INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
                                 WHERE OEUVRE.noOeuvre = ".$numOeuvre." AND EXEMPLAIRE.noExemplaire = ".$ligne["noExemplaire"].";";
        $res = $bdd->query($commande)->fetch();
        if($res["dispo"]){
        $style = "background-color:lime;";
        $isDispo = "(disponible) ";
        }
        ?>
        <tr style="<?php echo($style) ?>">
            <td><?php echo($ligne["noExemplaire"]) ?>   <?php echo($isDispo) ?></td>
            <td><?php echo($ligne["etat"]) ?></td>
            <td><?php echo($ligne["dateAchat"]) ?></td>
            <td><?php echo($ligne["prix"]) ?></td>
            <td>
                <a href="Exemplaire_edit.php?idToEdit=<?php echo($ligne["noExemplaire"]) ?>">Modifier</a>
                <a href="Exemplaire_delete.php?idToDel=<?php echo($ligne["noExemplaire"]) ?>&noOeuvre=<?php echo $oeuvre["noOeuvre"]?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <br><br>
            <div class="titreMenu"> Aucun exemplaire disponible !</div>
    <?php endif; ?>
</div>


<?php include ("v_foot.php");  ?>
