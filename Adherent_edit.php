<?php
include ("connexion_bdd.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

if(isset($_GET)){
    if(isset($_GET["idToEdit"])){
        $commande = "SELECT * FROM ADHERENT WHERE idAdherent = ".$_GET["idToEdit"].";";
        $adherent = $bdd->query($commande)->fetch();
        echo "string";
    }
}


  if(isset($_POST["form_insert_Adherent_Valider"]) AND isset($_POST["nomAdherent"])  AND isset($_POST["adresse"]) AND isset($_POST["datePaiement"])){

      $nomAdherent=$_POST["nomAdherent"];
      $adresse=$_POST["adresse"];
      $datePaiement=$_POST["datePaiement"];



      $chaine_SQL="UPDATE ADHERENT SET nomAdherent='".$nomAdherent."',adresse='".$adresse."',datePaiement'".$datePaiement."') WHERE idAdherent='".$_GET['idAdherent']."';'";

      $nbrInsert= $bdd->query($chaine_SQL);

      header("Location: Adherent_show.php");
      }


?>

<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
  <form action="Adherent_edit.php?idToEdit="<?php echo $_GET['idAdherent']?>. method="post">
    <fieldset>
      nom : <input type="text" name="nomAdherent" value="<?php echo $adherent['nomAdherent']?>" />
      adresse : <input type="text" name="adresse" value="<?php echo $adherent['adresse']?>" />
      date de paiement : <input type="date" name="datePaiement" value="<?php echo $adherent['datePaiement']?>" />
      <input type="submit" name="form_insert_Adherent_Valider" value="Valider" />
    </fieldset>
  </form>
  <a href="Adherent_show.php">Retour</a>
</div>

<?php include ("v_foot.php");  ?>
