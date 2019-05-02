<?php
include("connexion_bdd.php");
// traitement
$erreurNom = false;



if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{              // le formulaire vient d'être soumis

    if(isset($_POST["nom"])&& isset($_POST["prenom"]) && isset($_POST["idAuteur"])){

        $_GET["idToEdit"] = $_POST["idAuteur"];

        if(strlen($_POST["nom"]) < 2){
            $erreurNom = true;
        }

        if(!$erreurNom){
            $commande = "UPDATE AUTEUR SET AUTEUR.nomAuteur = '".$_POST["nom"]."',
                                       AUTEUR.prenomAuteur = '".$_POST["prenom"]."'
                     WHERE AUTEUR.idAuteur = ".$_POST["idAuteur"].";";
            $suc = $bdd->exec($commande);
            header("Location: Auteur_show.php?editSuc=".$suc);
        }

    }
}

if(isset($_GET)){
    if(isset($_GET["idToEdit"])){
        $commande = "SELECT * FROM AUTEUR WHERE AUTEUR.idAuteur = ".$_GET["idToEdit"].";";
        $auteur = $bdd->query($commande)->fetch();
    }
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">

    <a href="Auteur_show.php">Retour</a>
    <?php if(isset($auteur)): ?>
        <?php if(isset($auteur["idAuteur"])): ?>
            <form action="Auteur_edit.php" method="post">
                <fieldset>
                    <legend>
                        Modification de l'auteur <?php echo($auteur["nomAuteur"]); ?> <?php echo($auteur["prenomAuteur"]); ?>
                    </legend>
                    <input type="hidden" value="<?php echo($auteur["idAuteur"]);?>" name="idAuteur">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" value="<?php echo($auteur["nomAuteur"]);?>">
                    <?php if($erreurNom): ?> <div style="color: red">Erreur le nom contient minimum 2 caractères</div><?php endif; ?>
                    <br>
                    <label for="prenom">Prenom</label>
                    <input type="text" name="prenom" value="<?php echo($auteur["prenomAuteur"]);?>"><br>
                    <input type="submit" value="Valider">
                </fieldset>
            </form>
        <?php else: ?>
            <div class="erreur" style="color: red">
                Erreur , l'auteur n'a pas été trouvé. Avez vous selectionné un auteur dans la liste ?
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="erreur" style="color: red">
            Erreur , aucun auteur selectionné. Avez vous selectionné un auteur dans la liste ?
        </div>
    <?php endif; ?>


</div>

<?php include ("v_foot.php");  ?>
