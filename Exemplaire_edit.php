<?php
include("connexion_bdd.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}


$oeuvre = null;
$exemplaire = null;

if(isset($_GET)){
    if(isset($_GET["noOeuvre"])){
        $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.idOeuvre = ".$_GET["noOeuvre"].";";
        $oeuvre = $bdd->query($commande)->fetch();
    }

    if(isset($_GET["noExemplaire"])){
        $commande = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noExemplaire = ".$_GET["noExemplaire"];
        $exemplaire = $bdd->query($commande)->fetch();
    }

}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <form action="Exemplaire_edit.php" method="post">
        <caption>
            <fieldset>
                <legend>Modification de l'exemplaire <?php echo($exemplaire["noExemplaire"]) ?></legend>
            </fieldset>
        </caption>
    </form>
</div>

<?php include ("v_foot.php");  ?>
