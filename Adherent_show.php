<?php
include("connexion_bdd.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

// affichage de la vue
?>
<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>
<div class="row">
  <a href="Adherent_add.php"> Ajouter</a>


  <?php
    if(isset($_GET["suprimer"])){
      $supr=$_GET["suprimer"];
      $chaine_SQL2="DELETE FROM ADHERENT WHERE idAdherent=".$supr.";";
      $suprRes= $bdd->exec($chaine_SQL2);
    }
    $chaine_SQL="SELECT * FROM ADHERENT;";


    $reponse= $bdd->query($chaine_SQL);
    $donnee = $reponse->fetchAll();
    // header("Location: Etudiant_show_result.php");


  ?>

  <table border="1">
    <th>id</th><th>nom</th><th>adresse</th><th>date paiment</th>
    <?php foreach($donnee as $row): ?>
        <?php
            echo "<tr><td>".$row['idAdherent']."</td><td>".$row['nomAdherent'].
            "</td><td>".$row['adresse']."</td><td>".$row['datePaiement'].
            "</td><td><a href='Adherent_show.php?suprimer=".$row['idAdherent'].
            "'>Suprimer</a></td>";?>
    <?php endforeach;?>
  </table>
</div>
<?php include ("v_foot.php");  ?>
