<?php
include("connexion_bdd.php");


$champsok = false;
// traitement
if(isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]))  // si il existe certaines variables dans le tableau associatif $_POST
{                // le formulaire vient d'être soumis
    $champsok = true;
    $commande = "INSERT INTO AUTEUR (idAuteur,nomAuteur,prenomAuteur)
                 VALUES (NULL,'".$_POST["nom"]."','".$_POST["prenom"]."');";
    $res = $bdd->exec($commande);
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <form action="Auteur_add.php" method="post">
        <fieldset>
            <legend>Ajout d'un auteur</legend>
            <label for="nom">Nom de l'auteur: </label><input type="text" name="nom" required><br>
            <label for="prenom">Prenom de l'auteur: </label> <input type="text" name="prenom" required><br>
            <input type="submit">
        </fieldset>
    </form>
    <?php if($champsok): ?>
        <?php if($res == 1): ?>
            <p style="color: green">Auteur <?php echo($_POST["nom"])?> <?php echo($_POST["prenom"])?> ajouté avec succès! </p>
        <?php else: ?>
            <p style="color: red">
                Erreur lors de l'ajout de l'auteur <?php echo($_POST["nom"])?> <?php echo($_POST["prenom"])?>
                , veuillez réessayer ultérieurement
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include ("v_foot.php");  ?>
