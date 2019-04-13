<?php
include("connexion_bdd.php");
// traitement

$donnesOk = false;

if(isset($_GET)){
    if(isset($_GET["idToDel"])){
        $donnesOk = true;
        $commande = "SELECT * FROM AUTEUR WHERE idAuteur=".$_GET["idToDel"].";";
        $auteur = $bdd->query($commande)->fetch();

        $commande = "SELECT OEUVRE.noOeuvre, OEUVRE.titre FROM OEUVRE
                     INNER JOIN AUTEUR ON OEUVRE.idAuteur = AUTEUR.idAuteur
                     WHERE OEUVRE.idAuteur = ".$_GET["idToDel"]." ;";
        $oeuvresLiees = $bdd->query($commande)->fetchAll();
        //$oeuvresDeLauteur
    }
}

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    if(isset($_POST["deleteId"])){
        $commande = "DELETE FROM AUTEUR WHERE AUTEUR.idAuteur = ".$_POST["deleteId"].";";
        $deleteSuccess = $bdd->exec($commande);
        echo("okmr");
        header("Location: Auteur_show.php?delSuc=".$deleteSuccess);
    }
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <?php if($donnesOk): ?>
        <?php if(!isset($auteur["idAuteur"])): ?>
            <div class="erreur">Auteur non trouvé, avez vous selectionner un auteur valide ?</div>
        <?php else: ?>
            <div class="titreMenu">
                Suppression de l'auteur <?php echo($auteur["nomAuteur"]); ?> <?php echo($auteur["prenomAuteur"]); ?>
            </div>
            <div class="alert">
                Voulez vous vraiment supprimer l'auteur en question ? <br>
                <?php if(isset($oeuvresLiees[0])): ?>
                    les oeuvres suivantes ainsi que tout leurs exemplaires seronts supprimées:
                    <ul>
                        <?php foreach ($oeuvresLiees as $ligne): ?>
                            <li><?php echo($ligne["titre"]); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <form action="Auteur_show.php"><input type="submit" value="Annuler"></form>
            <form action="Auteur_delete.php" method="post">
                    <input type="hidden" value="<?php echo($auteur["idAuteur"]); ?>" name="deleteId">
                    <input type="submit" value="Continuer">

            </form>
        <?php endif; ?>
    <?php else: ?>
        <div class="erreur">Une erreur s'est produite veuillez réessayer ultérieurement</div>
    <?php endif; ?>
</div>

<?php include ("v_foot.php");  ?>
