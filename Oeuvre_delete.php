<?php
include("connexion_bdd.php");
// traitement

$donnesOk = false;

if(isset($_GET)){
    if(isset($_GET["idToDel"])){
        $donnesOk = true;
        $commande = "SELECT * FROM OEUVRE WHERE";
    }
}

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->

<?php include ("v_foot.php");  ?>
