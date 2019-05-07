<?php
include("connexion_bdd.php");
include("fonctionsUtiles.php");
// traitement

$commande = "SELECT * FROM AUTEUR;";
$auteurs = $bdd->query($commande)->fetchAll();

$errNom = false;
$errDate = false;
$errAuteur = false;

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{   // le formulaire vient d'être soumis
    if(isset($_POST["titre"]) && isset($_POST["auteur"]) && isset($_POST["date"])){
        if(strlen($_POST["titre"]) < 2){
            $errNom = true;
        }else{
            $champTitre = $_POST["titre"];
        }

        if($_POST["auteur"] == 0){
            $errAuteur = true;
        }else{
            $champAuteur = $_POST["auteur"];
        }


        $verifDate = dateValide($_POST["date"]);
        if($verifDate == "Veuillez entrer une date valide !" || $verifDate == "Veuillez entrer une date au format jj/mm/aaaa"){
            $errDate = true;
        }else{
            $champDate = $verifDate;
        }

        if(!$errNom && !$errDate && !$errAuteur){
            //On ajoute !
            $commande = "UPDATE OEUVRE SET OEUVRE.titre = ".$_POST["titre"].",
                                           OEUVRE.idAuteur = ".$_POST["auteur"].",
                                           OEUVRE.dateParution = ".$_POST["date"]."
                                           WHERE OEUVRE.noOeuvre = ".$_POST["noOeuvre"].";";
            $succ = $bdd->exec($commande);
            header("Location: Oeuvre_show.php?editSuc=".$succ);
        }
    }
}

if(isset($_GET)){
    if(isset($_GET["idToEdit"])){

        $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_GET["idToEdit"].";";
        $oeuvre = $bdd->query($commande)->fetch();
    }
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>
<!-- affichage(vue) relatif à la page -->


<div class="row">
    <a href="Oeuvre_show.php">Retour</a>
    <form action="Oeuvre_edit.php" method="post">
        <fieldset>
            <legend>Ajout d'une Oeuvre</legend>
            <input type="hidden" value="<?php echo($oeuvre["noOeuvre"]);?>" name="noOeuvre">
            <label for="titre">Titre</label><input type="text" name="titre" value="<?php echo($oeuvre["titre"])?>">
            <?php if($errNom): ?>
                <br><div class="erreur" style="color: red">Le titre doit faire au minimum 2 lettres!</div>
            <?php endif; ?>
            <br>
            <label for="auteur">Auteur</label><br>
            <select name="auteur" id="">
                <option value="0">--Veuillez selectionnez un auteur--</option>
                <?php foreach ($auteurs as $ligne): ?>
                    <option value="<?php echo($ligne["idAuteur"]);?>" <?php if($ligne["idAuteur"] == $oeuvre["noOeuvre"]){echo("selected");}?>>
                        <?php echo($ligne["prenomAuteur"]);?>
                        <?php echo($ligne["nomAuteur"]);?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <?php if($errAuteur): ?>
                <div class="erreur" style="color: red">Veuillez entrez un auteur valide !</div>
            <?php endif; ?>
            <br>
            <label for="date">Date de parution</label>
            <input type="text" name="date" value="<?php echo(dateBddToFr($oeuvre["dateParution"]))?>">
            <?php if($errDate): ?>
                <br><div class="erreur" style="color: red"><?php echo($verifDate)?></div>
            <?php endif; ?>
            <br>
            <input type="submit" value="Valider">
        </fieldset>
    </form>
</div>

<?php include ("v_foot.php");  ?>
