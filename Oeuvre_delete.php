<?php
include("connexion_bdd.php");
// traitement

$donnesOk = false;

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    if(isset($_POST["deleteId"])){
        $commande = "DELETE FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_POST["deleteId"].";";
        $res = $bdd->exec($commande);
        header("Location: Oeuvre_show.php?delSuc=".$res);
    }
}

if(isset($_GET)){
    if(isset($_GET["idToDel"])){
        $donnesOk = true;
        if($_GET["nbr"] == 0){
            $commande = "DELETE FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_GET["idToDel"].";";
            $res = $bdd->exec($commande);
            header("Location: Oeuvre_show.php?delSuc=".$res);
        }

        $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_GET["idToDel"].";";
        $infoOeuvre = $bdd->query($commande)->fetchAll()[0];


    }
}



// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <div class="titreMenu">Suppression de l'oeuvre '<?php echo($infoOeuvre["titre"]) ?>' </div>
    <?php if($_GET["nbr"] == 1): ?>
        <div class="erreur" style="color: red">Attention! l'exemplaire associé sera supprimé !</div>
    <?php else: ?>
        <div class="erreur" style="color: red">Attention! les <?php echo($_GET["nbr"]) ?> exemplaires associé(s) seront supprimés !</div>
    <?php endif; ?>
    <form action="Oeuvre_show.php"><input type="submit" value="Annuler"></form>
    <form action="Oeuvre_delete.php" method="post">
        <input type="hidden" value="<?php echo($infoOeuvre["noOeuvre"]); ?>" name="deleteId">
        <input type="submit" value="Continuer">
    </form>
</div>

<?php include ("v_foot.php");  ?>
