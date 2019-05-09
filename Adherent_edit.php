<?php
include ("connexion_bdd.php");
include ("fonctionsUtiles.php");

// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

$nomAdherent ="";
$adresse ="";
$datePaiement ="";
$testNom=true;
$testAdresse=true;
$testDate =true;

if(isset($_GET)){
    if(isset($_GET["idToEdit"])){
        $commande = "SELECT * FROM ADHERENT WHERE idAdherent = ".$_GET["idToEdit"].";";
        $adherent = $bdd->query($commande)->fetch();
        echo "string";
    }
}


  if(isset($_POST["form_insert_Adherent_Valider"]) AND isset($_POST["nomAdherent"])  AND isset($_POST["adresse"]) AND isset($_POST["datePaiement"])){

      $nomAdherent=texteValide($_POST["nomAdherent"]);
      $adresse=texteValide($_POST["adresse"]);
      $datePaiement=texteValide($_POST["datePaiement"]);
      $idAdherent = $_GET['idToEdit'];

      if($nomAdherent ==  "Veuillez rentrer un texte de plus de deux charactère, espace exclus"){
        $testNom = false;
      }else {
        $testNom = true;
      }

      if($adresse ==  "Veuillez rentrer un texte de plus de deux charactère, espace exclus"){
        $testAdresse = false;
      }else {
        $testAdresse = true;
      }

      if($datePaiement ==   "Veuillez entrer une date valide !" || $datePaiement == "Veuillez entrer une date au format jj/mm/aaaa"){
        $testDate = false;
      }else {
        $testDate = true;
      }

      if (($testNom == true) AND ($testDate == true) AND ($testAdresse == true)){

        $chaine_SQL="UPDATE ADHERENT SET nomAdherent='".$nomAdherent."',adresse='".$adresse."',datePaiement='".$datePaiement."' WHERE idAdherent='".$idAdherent."';";

        $nbrInsert= $bdd->query($chaine_SQL);

        header("Location: Adherent_show.php");
      }
    }


?>

<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
  <form action="Adherent_edit.php?idToEdit=<?php echo $adherent['idAdherent'] ?>" method="post">
    <fieldset>
      nom : <input type="text" name="nomAdherent" value="<?php echo $adherent['nomAdherent']?>" />
      <div class="erreur"><?php if($testNom == false){echo $nomAdherent;}; ?></div>
      adresse : <input type="text" name="adresse" value="<?php echo $adherent['adresse']?>" />
      <div class="erreur"><?php if($testAdresse == false){echo $adresse;}; ?></div>
      date de paiement : <input type="text" name="datePaiement" value="<?php echo $adherent['datePaiement']?>" />
      <div class="erreur"><?php if($testDate == false){echo $datePaiement;}; ?></div>
      <input type="submit" name="form_insert_Adherent_Valider" value="Valider" />
    </fieldset>
  </form>
  <a href="Adherent_show.php">Retour</a>
</div>

<?php include ("v_foot.php");  ?>
