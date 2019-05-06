<?php
include("connexion_bdd.php");
include("fonctionsUtiles.php");
// traitement

$commande = "SELECT * FROM AUTEUR;";
$auteurs = $bdd->query($commande)->fetchAll();

$errNom = false;
$errDate = false;

$champTitre = "";
$champAuteur = 0;
$champDate = "";

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    if(isset($_POST["titre"]) && isset($_POST["auteur"]) && isset($_POST["date"])){
        if(strlen($_POST["titre"]) < 2){
            $errNom = true;
        }else{
            $champTitre = $_POST["titre"];
        }

        $champAuteur = $_POST["auteur"];

        $verifDate = dateValide($_POST["date"]);
        if($verifDate == "Veuillez entrer une date valide !" || $verifDate == "Veuillez entrer une date au format jj/mm/aaaa"){
            $errDate = true;
        }else{
            $champDate = $verifDate;
        }

        if(!$errNom && !$errDate){
            //On ajoute !
            $commande = "INSERT INTO OEUVRE (noOeuvre,titre,dateParution,idAuteur)
                         VALUES (NULL,'".$_POST["titre"]."','".$verifDate."',".$_POST["auteur"].");";
            $succ = $bdd->exec($commande);
            header("Location: Oeuvre_show.php?addSuc=".$succ);
        }
    }
}

if(isset($_GET)){

}
// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
    <a href="Oeuvre_show.php">Retour</a>
    <form action="Oeuvre_add.php" method="post">
        <fieldset>
            <legend>Ajout d'une Oeuvre</legend>
            <label for="titre">Titre</label><input type="text" name="titre" value="<?php echo($champTitre)?>">
            <?php if($errNom): ?>
                <br><div class="erreur" style="color: red">Le titre doit faire au minimum 2 lettres!</div>
            <?php endif; ?>
            <br>
            <label for="auteur">Auteur</label><br>
            <select name="auteur" id="">
                <?php foreach ($auteurs as $ligne): ?>
                    <option value="<?php echo($ligne["idAuteur"]);?>" <?php if($ligne["idAuteur"] == $champAuteur){echo("selected");}?>>
                        <?php echo($ligne["prenomAuteur"]);?>
                        <?php echo($ligne["nomAuteur"]);?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
            <label for="date">Date de parution</label>
            <input type="text" name="date" value="<?php echo($champDate)?>">
            <?php if($errDate): ?>
                <br><div class="erreur" style="color: red"><?php echo($verifDate)?></div>
            <?php endif; ?>
            <br>
            <input type="submit" value="Valider">
        </fieldset>
    </form>
</div>
<!-- affichage(vue) relatif à la page -->

<?php include ("v_foot.php");  ?>
