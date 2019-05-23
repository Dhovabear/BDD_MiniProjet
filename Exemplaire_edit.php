<?php
include("connexion_bdd.php");
include("fonctionsUtiles.php");
// traitement

$champEtat = 0;
$champDate = "";
$champPrix = 0;

$errEtat = false;
$errDate = false;
$errPrix = false;

$idToEdit = 0;
$oeuvre = null;

if(isset($_POST) &&  isset($_POST["noOeuvre"]) )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    if(isset($_POST["noOeuvre"])){
        $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_POST["noOeuvre"].";";
        $oeuvre = $bdd->query($commande)->fetch();
    }

    if(isset($_POST["idToEdit"])){
        $idToEdit = 28;
        $commande = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noExemplaire = ".$_POST["idToEdit"];
        $exemplaire = $bdd->query($commande)->fetch();
    }

    if(isset($_POST["etat"])){
        if($_POST["etat"] == 0){
            $champEtat = $exemplaire["etat"];
            $errEtat = true;
        }else{
            $champEtat = $_POST["etat"];
        }
    }else{
        $champEtat = $exemplaire["etat"];
        $errEtat = true;
    }

    if(isset($_POST["dateAchat"])){
        $dateAchatErr = dateValide($_POST["dateAchat"]);
        if($dateAchatErr == "Veuillez entrer une date valide !" || $dateAchatErr == "Veuillez entrer une date au format jj/mm/aaaa"){
            $champDate = dateBddToFr($exemplaire["dateAchat"]);
            $errDate = true;
        }else{
            $champDate = dateValide($dateAchatErr);
        }
    }else{
        $champDate = dateBddToFr($exemplaire["dateAchat"]);
        $errDate = true;
    }

    if(isset($_POST["prix"])){
        if($_POST["prix"] <= 0){
            $champPrix = $exemplaire["prix"];
            $errPrix = true;
        }else{
            $champPrix = $_POST["prix"];
        }
    }else{
        $champPrix = $exemplaire["prix"];
        $errPrix = false;
    }

    if(!$errPrix && !$errDate && !$errEtat){
        $d = dateValide($_POST["dateAchat"]);
        $et = "";
        switch ($_POST["etat"]){
            case 1: $et = "NEUF";break;
            case 2: $et = "BON";break;
            case 3: $et = "MOYEN";break;
            case 4: $et = "MAUVAIS";break;
        }
        $commande = "UPDATE EXEMPLAIRE SET EXEMPLAIRE.etat = ".$bdd->quote($et).",
                                           EXEMPLAIRE.dateAchat = ".$bdd->quote($d).",
                                           EXEMPLAIRE.prix = ".$_POST["prix"]."
                     WHERE EXEMPLAIRE.noExemplaire = ".$_POST["idToEdit"].";";
        $res = $bdd->exec($commande);
        header("Location: Exemplaire_show.php?noOeuvre=".$_POST["noOeuvre"]."&editSuc=".$res);
    }
}



$exemplaire = null;

if(isset($_GET)){
    if(isset($_GET["noOeuvre"])){
        $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_GET["noOeuvre"].";";
        $oeuvre = $bdd->query($commande)->fetch();
    }

    if(isset($_GET["idToEdit"])){
        $commande = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noExemplaire = ".$_GET["idToEdit"];
        $exemplaire = $bdd->query($commande)->fetch();

        $idToEdit = $_GET["idToEdit"];

        if($exemplaire["etat"] == "NEUF"){
            $champEtat = 1;
        }else if($exemplaire["etat"] == "BON"){
            $champEtat = 2;
        }else if($exemplaire["etat"] == "MOYEN"){
            $champEtat = 3;
        }else if($exemplaire["etat"] == "MAUVAIS"){
            $champEtat = 4;
        }

        $champDate = dateBddToFr($exemplaire["dateAchat"]);

        $champPrix = $exemplaire["prix"];
    }

}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">
    <a href="Exemplaire_show.php?noOeuvre=<?php echo $oeuvre["noOeuvre"]?>">retour</a>
    <form action="Exemplaire_edit.php" method="post">
        <caption>
            <fieldset>
                <legend>Modification de l'exemplaire <?php echo($idToEdit)?> de <?php echo($oeuvre["titre"]) ?></legend>
                <input type="hidden" value="<?php echo($oeuvre["noOeuvre"]) ?>" name="noOeuvre">
                <input type="hidden" value="<?php echo($idToEdit) ?>" name="idToEdit">
                <label>Etat: </label>
                <input type="radio" name="etat" value="1" <?php if($champEtat == 1){echo "checked";} ?>> NEUF -
                <input type="radio" name="etat" value="2" <?php if($champEtat == 2){echo "checked";} ?>> BON -
                <input type="radio" name="etat" value="3" <?php if($champEtat == 3){echo "checked";} ?>> MOYEN -
                <input type="radio" name="etat" value="4" <?php if($champEtat == 4){echo "checked";} ?>> MAUVAIS
                <?php if($errEtat):?>
                    <div class="erreur" style="color:red">Veuillez renseignez un état !</div>
                <?php endif;?>
                <br>
                <br>
                <label for="dateAchat">Date achat: </label> <input type="text" name="dateAchat" value="<?php echo $champDate ?>">
                <?php if($errDate): ?>
                    <div class="erreur" style="color: red"> <?php echo $dateAchatErr ?></div>
                <?php endif; ?>
                <br>
                <label for="prix">Prix: </label><input type="text" name="prix" value="<?php echo $champPrix ?>">
                <?php if($errPrix): ?>
                    <div class="erreur" style="color: red">Veuillez entrer un prix valide !</div>
                <?php endif; ?>
                <br>
                <input type="submit" value="Modifier">
            </fieldset>
        </caption>
    </form>
</div>

<?php include ("v_foot.php");  ?>
