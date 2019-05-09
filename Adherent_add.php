<?php
include ("connexion_bdd.php");
include ("fonctionsUtiles.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

// affichage de la vue
?>
<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>



<?php


  if(isset($_POST["form_insert_Adherent_Valider"]) AND isset($_POST["nomAdherent"])  AND isset($_POST["adresse"]) AND isset($_POST["datePaiement"])){

      $nomAdherent=texteValide($_POST["nomAdherent"]);
      $adresse=texteValide($_POST["adresse"]);
      $datePaiement=dateValide($_POST["datePaiement"]);

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
        $chaine_SQL="INSERT INTO ADHERENT (idAdherent,nomAdherent,adresse,datePaiement) VALUES ( NULL,'".$nomAdherent."','".$adresse."','".$datePaiement."');";

        $nbrInsert= $bdd->query($chaine_SQL);

      }
      header("Location: Adherent_show.php");
      }


?>

<div class="row">
  <form action="#" method="post">
    <fieldset>
      nom : <input type="text" name="nomAdherent" value="" required/>
      adresse : <input type="text" name="adresse" value="" required/>
      date de paiement : <input type="date" name="datePaiement" value="" required/>
      <input type="submit" name="form_insert_Adherent_Valider" value="Valider" />
    </fieldset>
  </form>
  <a href="Adherent_show.php">Retour</a>
</div>

<?php include ("v_foot.php");  ?>
