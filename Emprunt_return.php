<?php
include ("connexion_bdd.php");
include ("fonctionsUtiles.php");
// traitement
$commande = "SELECT * FROM ADHERENT ;";
$adherent = $bdd->query($commande)->fetchAll();

$visible2 = "none";
$adPost = 0;

if (isset($_POST['reset'])){
  header("Location: Emprunt_return.php?");
}

if (isset($_POST['rendu']) and isset($_POST['dateRendu'])){
  $dateRendu = $_GET['dateRendu'];
  $rendu = $_GET['rendu'];
  $commandrendre = "UPDATE EMPRUNT SET dateEmprunt= '".$dateRendu."' WHERE noExemplaire ='".$rendu."';";
  $fin = $bdd->exec($commandrendre)->fetch();
}

if (isset($_GET['confirm']) and $_GET['confirm'] != 0){
  $adPost =$_GET['confirm'];
  $visible2 = "inline";
  $commande = "SELECT * FROM ADHERENT WHERE idAdherent =".$adPost." ;";
  $adherent = $bdd->query($commande)->fetch();
  $commande2 = "SELECT OEUVRE.titre,EMPRUNT.noExemplaire, EMPRUNT.dateEmprunt, COUNT(EXEMPLAIRE.noExemplaire) AS gounter
                FROM EMPRUNT
                INNER JOIN EXEMPLAIRE ON EXEMPLAIRE.noExemplaire = EMPRUNT.noExemplaire
                INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
                INNER JOIN ADHERENT ON ADHERENT.idAdherent = EMPRUNT.idAdherent
                WHERE ADHERENT.idAdherent = '".$adPost."' and EMPRUNT.dateRendu IS NULL
                GROUP BY OEUVRE.noOeuvre ;";
  $result = $bdd->query($commande2)->fetchAll();
}elseif (isset($_POST['adherent']) and $_POST['adherent'] != 0){
  $adPost = $_POST['adherent'];
  $visible2 = "inline";
  $commande = "SELECT * FROM ADHERENT WHERE idAdherent =".$adPost." ;";
  $adherent = $bdd->query($commande)->fetch();
  $commande2 = "SELECT OEUVRE.titre,EMPRUNT.noExemplaire, EMPRUNT.dateEmprunt, COUNT(EXEMPLAIRE.noExemplaire) AS gounter
                FROM EMPRUNT
                INNER JOIN EXEMPLAIRE ON EXEMPLAIRE.noExemplaire = EMPRUNT.noExemplaire
                INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
                INNER JOIN ADHERENT ON ADHERENT.idAdherent = EMPRUNT.idAdherent
                WHERE ADHERENT.idAdherent = '".$adPost."' and EMPRUNT.dateRendu IS NULL
                GROUP BY OEUVRE.noOeuvre ;";
  $result = $bdd->query($commande2)->fetchAll();
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
          <table border="1">
            <th>titre</th><th>dateEmprunt</th><th>exemplaire</th><th>date de rendu</th><th>rendre</th>
            <?php foreach ($result as $ligne): ?>
                    <?php echo("<tr><td>'".$ligne['titre']."'</td><td>'".$ligne['dateEmprunt']."'</td><td>'".$ligne['gounter']."'</td><td><input type='text' name='dateRendu' value=".date("d/m/Y")." </td><td><input type='submit' name='rendre' value=".$ligne['noExemplaire']." </td>");?>
            <?php endforeach; ?>
          </table>
        </div>
    </fieldset>
  </form>

<?php include ("v_foot.php");  ?>
