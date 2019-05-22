<?php
include ("connexion_bdd.php");


$commande = "SELECT * FROM ADHERENT ;";
$adherent = $bdd->query($commande)->fetchAll();



$commande2 = "SELECT OEUVRE.noOeuvre, COUNT(EXEMPLAIRE.noExemplaire) AS compteur
              FROM OEUVRE
              RIGHT JOIN EXEMPLAIRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
              LEFT JOIN EMPRUNT ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
              WHERE EMPRUNT.noExemplaire IS NULL
              GROUP BY OEUVRE.noOeuvre
              ORDER BY OEUVRE.noOeuvre;";



$oeuvre = $bdd->query($commande2)->fetchAll();


// $commande3 = "INSERT INTO EMPRUNT VALUES";

$visible2 = "none";
$adPost = 0;

if (isset($_GET['adherent'])){
  $adPost = $_GET['adherent'];
  $visible2 = "inline";
  $commande = "SELECT * FROM ADHERENT WHERE idAdherent =".$adPost." ;";
  $adherent = $bdd->query($commande)->fetch();
}


?>
<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>


<div class="row">
  <form action="#" method="get">
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
        <input type="submit" value="Emprunter" >
      </div>
    </fieldset>
  </form>
  <a href="Emprunt_show.php">Retour</a>
</div>

<?php include ("v_foot.php");  ?>
