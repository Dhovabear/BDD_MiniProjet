<?php
include("connexion_bdd.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>
<div class="row">
  <a href="Adherent_add.php"> Ajouter</a>
</div>
<!-- affichage(vue) relatif à la page -->

<?php include ("v_foot.php");  ?>
