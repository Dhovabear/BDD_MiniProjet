<?php
include("connexion_bdd.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<?php

include('connexion.php');

if(isset($_POST["form_insert_Adherent_Valider"]) AND isset($_POST["nomAdherent"])  AND isset($_POST["adresse"] AND isset($_POST["datePaiement"]))
    {

    $nomAdherent=$_POST["nomAdherent"];
    $adresse=$_POST["adresse"];
    $datePaiement=$_POST["datePaiement"];



    $chaine_SQL="INSERT INTO Etudiant (Nom_ETU,Ville_ETU) VALUES ('".$nomAdherent."','".$adresse."','".$datePaiement."');";
        print "executer avec PDO :".$chaine_SQL."<br>";
    $nbrInsert= $ma_connexion_mysql->query($chaine_SQL);
    // header("Location: Etudiant_show_result.php");
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
</div>
<?php include ("v_foot.php");  ?>
