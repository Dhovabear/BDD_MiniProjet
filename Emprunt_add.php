<?php
include ("connexion_bdd.php");

$commande = "SELECT * FROM ADHERENT ;";
$adherent = $bdd->query($commande)->fetchAll();

$commande2 = "SELECT OEUVRE.noOeuvre, OEUVRE.titre
              , COUNT(EXEMPLAIRE.noOeuvre) AS gounter
              FROM OEUVRE
              INNER JOIN EXEMPLAIRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
              GROUP BY OEUVRE.noOeuvre
              ORDER BY OEUVRE.noOeuvre";
$oeuvre = $bdd->query($commande2)->fetchAll();

$visible2 = "hidden";
$adPost = 0;

if (isset($_GET['adherent'])){
  $adPost = $_GET['adherent'];
  $visible2 = "visible";
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
        <?php endif; ?>
      </fieldset>
        <div style="visibility: <?php echo $visible2;?>">
          <select name="rendu">
              <option value="0">--Veuillez selectionnez une oeuvre--</option>
              <?php foreach ($oeuvre as $ligne): ?>
                  <option value="<?php echo($ligne["noOeuvre"]);?>">
                      <?php echo $ligne["titre"]."-".$ligne["noOeuvre"];?>
                  </option>
              <?php endforeach; ?>
          </select>
        <input type="submit" value="Valider">
      </div>
    </fieldset>
  </form>
  <!-- <a href="Emprunt_show.php">Retour</a> -->
</div>

<?php include ("v_foot.php");  ?>
