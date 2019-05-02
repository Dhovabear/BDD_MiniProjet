<?php
include("connexion_bdd.php");

$erreurPrenom = false;
$erreurNom = false;

// traitement
if(isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]))  // si il existe certaines variables dans le tableau associatif $_POST
{                // le formulaire vient d'être soumis

    if(strlen($_POST["nom"]) < 2){
        $erreurNom = true;
    }




    if(!$erreurNom){
        $commande = "INSERT INTO AUTEUR (idAuteur,nomAuteur,prenomAuteur)
                 VALUES (NULL,'".$_POST["nom"]."','".$_POST["prenom"]."');";
        $res = $bdd->exec($commande);
        header("Location: Auteur_show.php?addSuc=".$res);
    }
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <a href="Auteur_show.php">Retour</a>
    <form action="Auteur_add.php" method="post">
        <fieldset>
            <legend>Ajout d'un auteur</legend>
            <label for="nom">Nom de l'auteur: </label><input type="text" name="nom" >
            <?php if($erreurNom): ?> <div style="color: red">Erreur le nom contient minimum 2 caractères</div><?php endif; ?>
            <br>
            <label for="prenom">Prenom de l'auteur: </label> <input type="text" name="prenom" >
            <br>
            <input type="submit" value="Valider">
        </fieldset>
    </form>

</div>

<?php include ("v_foot.php");  ?>
