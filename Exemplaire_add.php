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


if(isset($_POST["noOeuvre"]) && isset($_POST["dateAchat"]) && isset($_POST["prix"]))  // si il existe certaines variables dans le tableau associatif $_POST
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

    if(dateValide($_POST["dateAchat"]) == "Veuillez entrer une date valide !" || dateValide($_POST["dateAchat"]) == "Veuillez entrer une date au format jj/mm/aaaa"){
        $errDate = true;
    }else{
        $champDate = $_POST["dateAchat"];
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
                <br>
                <br>
                <label for="dateAchat">Date achat: </label> <input type="text" name="dateAchat"><br>
                <label for="prix">Prix: </label><input type="text" name="prix"><br>
                <input type="submit" value="Ajouter">

            </fieldset>
        </caption>
    </form>

</div>

<?php include ("v_foot.php");  ?>
