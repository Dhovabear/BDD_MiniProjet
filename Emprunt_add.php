<?php
include ("connexion_bdd.php");
include ("fonctionsUtiles.php");


$commande = "SELECT * FROM ADHERENT ;";
$adherent = $bdd->query($commande)->fetchAll();



$commandeExemplaireDispo = "SELECT OEUVRE.titre, OEUVRE.noOeuvre, COUNT(EXEMPLAIRE.noExemplaire) AS compteur
              FROM OEUVRE
              RIGHT JOIN EXEMPLAIRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
              LEFT JOIN EMPRUNT ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
              WHERE EMPRUNT.noExemplaire IS NULL
              GROUP BY OEUVRE.noOeuvre
              ORDER BY OEUVRE.noOeuvre;";





$oeuvre = $bdd->query($commandeExemplaireDispo)->fetchAll();


// $commande3 = "INSERT INTO EMPRUNT VALUES";

$visible2 = "none";
$adPost = 0;

if (isset($_POST['reset'])){
  header("Location: Emprunt_add.php?");
}

if (isset($_GET['confirm']) and $_GET['confirm'] != 0){
  $adPost =$_GET['confirm'];
  $visible2 = "inline";
  $commande = "SELECT * FROM ADHERENT WHERE idAdherent =".$adPost." ;";
  $adherent = $bdd->query($commande)->fetch();
}elseif (isset($_POST['adherent']) and $_POST['adherent'] != 0){
  $adPost = $_POST['adherent'];
  $visible2 = "inline";
  $commande = "SELECT * FROM ADHERENT WHERE idAdherent =".$adPost." ;";
  $adherent = $bdd->query($commande)->fetch();
}

if (isset($_POST['emprunt'])){
  $emPost = $_POST['emprunt'];
  $commandeUnExemplaire = "SELECT EXEMPLAIRE.noExemplaire
                FROM OEUVRE
                RIGHT JOIN EXEMPLAIRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
                LEFT JOIN EMPRUNT ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
                WHERE EMPRUNT.noExemplaire IS NULL and OEUVRE.noOeuvre = ".$emPost.";";
  $unExemplaire = $bdd->query($commandeUnExemplaire)->fetch();
  if(isset($_POST['dateEmprunt']) and $_POST['dateEmprunt'] != ""){
    $dateEmp = dateValide($_POST['dateEmprunt']);
    if ($dateEmp !=   "Veuillez entrer une date valide !" and $dateEmp != "Veuillez entrer une date au format jj/mm/aaaa" and $emPost != 0){
      $commandeFinal = "INSERT INTO EMPRUNT VALUES ('".$adPost."','".$unExemplaire["noExemplaire"]."','".$dateEmp."',NULL);";
      $fin = $bdd->exec($commandeFinal);
      header("Location: Emprunt_add.php?confirm=".$adPost);
    }
  }
}


?>
<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>


<div class="row">
  <form action="#" method="post">
    <fieldset>
      <fieldset >
        <?php if ($adPost == 0): ?>
          <select name="adherent" >
            <option value="0">--Veuillez selectionnez un adherent--</option>
            <?php foreach ($adherent as $ligne): ?>
                <option value="<?php echo($ligne["idAdherent"])?>">
                    <?php echo($ligne["nomAdherent"]);?>
                </option>
            <?php endforeach; ?>
          </select>
          <input type="submit" value="Valider">
        <?php else : ?>
          <?php echo "Adhérent selectionné : ".$adherent["nomAdherent"]; ?>
          <input type="submit" value="Changer d'adherent" name="reset" >
          <input type="hidden" name="adherent" value="<?php echo $adPost;?>">
        <?php endif; ?>
      </fieldset>
        <div style="display: <?php echo $visible2;?>">
          <select name="emprunt">
              <option value="0">--Veuillez selectionnez une oeuvre--</option>
              <?php foreach ($oeuvre as $ligne): ?>
                  <option value="<?php echo($ligne["noOeuvre"]);?>">
                      <?php echo $ligne["titre"]."-".$ligne["noOeuvre"];?>
                  </option>
              <?php endforeach; ?>
          </select>
        <input type="text" name="dateEmprunt" value="<?php echo date("d/m/Y");?>">
        <input type="submit" value="Emprunter" >
      </div>
    </fieldset>
  </form>
  <?php if(isset($emPost) or isset($_GET['confirm'])):?>
    <?php
    $commandeBilan = "SELECT ADHERENT.nomAdherent, OEUVRE.titre, EMPRUNT.dateEmprunt , COUNT(EXEMPLAIRE.noExemplaire) as nbrEx
                    FROM EMPRUNT
                    INNER JOIN ADHERENT ON ADHERENT.idAdherent = EMPRUNT.idAdherent
                    INNER JOIN EXEMPLAIRE ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
                    INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
                    WHERE ADHERENT.idAdherent =".$adPost."
                    GROUP BY OEUVRE.noOeuvre;";



    $empr = $bdd->query($commandeBilan)->fetchAll();
  ?>
    <table border="1">
      <th>titre</th><th>date Emprunt</th><th>Exemplaire</th>
      <?php foreach($empr as $row): ?>
          <?php
              echo "<tr><td>".$row['titre']."</td><td>".$row['dateEmprunt']."</td><td>".$row['nbrEx']."</td>" ?>
      <?php endforeach;?>
    </table>

<?php endif ?>
  <a href="Emprunt_show.php">Retour</a>
</div>

<?php include ("v_foot.php");  ?>
