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

<!-- affichage(vue) relatif à la page -->
<form action="POST">
    <label>Nom de l'auteur: </label><input type="text" name="nom"><br>
    <label for="prenom">Prenom de l'auteur: </label> <input type="text" name="prenom"><br>
</form>

<?php include ("v_foot.php");  ?>
