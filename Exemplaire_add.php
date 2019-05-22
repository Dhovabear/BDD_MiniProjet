<?php
include("connexion_bdd.php");
// traitement

include("fonctionsUtiles.php");

$errEtat = false;
$errDate = false;
$errPrix = false;

$champEtat = 0;
$champDate = "";
$champprix = "";



if(isset($_POST["noOeuvre"]) && isset($_POST["noOeuvre"]) && isset($_POST["prix"]))  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_POST["noOeuvre"].";";
    $oeuvre = $bdd->query($commande)->fetch();


    if(isset($_POST["etat"])){
        if($_POST["etat"] == 0){
            $errEtat = true;
        }else{
            $champEtat = $_POST["etat"];
        }
    }else{
        $errEtat = true;
    }

    $dateAchatErr = dateValide($_POST["dateAchat"]);
    if($dateAchatErr == "Veuillez entrer une date valide !" || $dateAchatErr == "Veuillez entrer une date au format jj/mm/aaaa"){
        $errDate = true;
    }else{
        $champDate = $_POST["dateAchat"];
    }

    if($_POST["prix"] > 0){
        $champprix = $_POST["prix"];
    }else{
        $errPrix = true;
    }

    if(!$errPrix && !$errDate && !$errEtat){
        $etatIns = "";
        switch ($_POST["etat"]){
            case 1: $etatIns = "NEUF";break;
            case 2: $etatIns = "BON";break;
            case 3: $etatIns = "MOYEN";break;
            case 4: $etatIns = "MAUVAIS";break;
        }
        $commande = "INSERT INTO EXEMPLAIRE VALUES (NULL,".$bdd->quote($etatIns).",".$bdd->quote(dateValide($_POST["dateAchat"]))."
                                                    ,".$_POST["prix"].",".$_POST["noOeuvre"].");";
        $res = $bdd->exec($commande);
        header("Location: Exemplaire_show.php?addSuc=".$res."&noOeuvre=".$_POST["noOeuvre"]);
    }


}


if(isset($_GET["idOeuvre"])){
    $commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$_GET["idOeuvre"].";";
    $oeuvre = $bdd->query($commande)->fetch();
}
// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->
<div class="row">

    <form action="Exemplaire_add.php" method="post">
        <caption>
            <fieldset>
                <br>
                <legend>Ajout d'un exemplaire de <?php echo($oeuvre["titre"]) ?></legend>
                <input type="hidden" value="<?php echo($oeuvre["noOeuvre"]) ?>" name="noOeuvre">
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
                <label for="prix">Prix: </label><input type="text" name="prix" value="<?php echo $champprix ?>">
                <?php if($errPrix): ?>
                        <div class="erreur" style="color: red">Veuillez entrer un prix valide !</div>
                <?php endif; ?>
                <br>
                <input type="submit" value="Ajouter">

            </fieldset>
        </caption>
    </form>

</div>

<?php include ("v_foot.php");  ?>
