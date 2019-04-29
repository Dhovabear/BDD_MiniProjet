<?php
include("connexion_bdd.php");
// traitement

$donnesOk = false;

if(isset($_GET)){
    if(isset($_GET["idToDelAd"])){
        $donnesOk = true;
        $commande = "SELECT * FROM ADHERENT WHERE idAdherent=".$_GET["idToDelAd"].";";
        $auteur = $bdd->query($commande)->fetch();

        $commande = "SELECT OEUVRE.noOeuvre, OEUVRE.titre FROM OEUVRE
                     INNER JOIN AUTEUR ON OEUVRE.idAdherent = ADHERENT.idAdherent
                     WHERE OEUVRE.idAuteur = ".$_GET["idToDelAd"]." ;";
        $oeuvresLiees = $bdd->query($commande)->fetchAll();
        //$oeuvresDeLauteur
    }
}

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    if(isset($_POST["deleteIdAd"])){
        $commande = "DELETE FROM ADHERENT WHERE ADHERENT.idAdherent = ".$_POST["deleteIdAd"].";";
        $deleteSuccess = $bdd->exec($commande);
        echo("okmr");
        header("Location: Adherent_show.php?delSuc=".$deleteSuccess);
    }
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <?php if($donnesOkAd): ?>
        <?php if(!isset($adherent["idAdherent"])): ?>
            <div class="erreur">Adherent non trouvé, avez vous selectionner un adherent valide ?</div>
        <?php else: ?>
            <div class="titreMenu">
                Suppression de l'adherent <?php echo($adherent["nomAuteur"]); ?> <?php echo($adherent["prenomAuteur"]); ?>
            </div>
            <div class="alert">
                Voulez vous vraiment supprimer l'adherent en question ? <br>
                <?php if(isset($oeuvresLiees[0])): ?>
                    les oeuvres suivantes ainsi que tout leurs exemplaires seronts supprimées:
                    <ul>
                        <?php foreach ($oeuvresLiees as $ligne): ?>
                            <li><?php echo($ligne["titre"]); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <form action="Adherent_show.php"><input type="submit" value="Annuler"></form>
            <form action="Adherent_delete.php" method="post">
                    <input type="hidden" value="<?php echo($adherent["idAdherent"]); ?>" name="deleteIdAD">
                    <input type="submit" value="Continuer">

            </form>
        <?php endif; ?>
    <?php else: ?>
        <div class="erreur">Une erreur s'est produite veuillez réessayer ultérieurement</div>
    <?php endif; ?>
</div>

<?php include ("v_foot.php");  ?>
