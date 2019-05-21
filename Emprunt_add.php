<?php
include ("connexion_bdd.php");

$commande = "SELECT * FROM ADHERENT ;";
$adherent = $bdd->query($commande)->fetchAll();
$visible2 = false;
$adPost = 0;

if (isset($_POST['adherent'])){
  $visible2 = true;
  $adPost = $_POST['adherent'];
}


?>
<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>


<div class="row" style="visibility='false';">
  <?php echo $adPost; echo $visible2;?>

  <form action="#" method="post">
    <fieldset>
      <label></label>
      <select name="adherent" >
          <option value="0">--Veuillez selectionnez un adherent--</option>
          <?php foreach ($adherent as $ligne): ?>
              <option value="<?php echo($ligne["idAdherent"])?>">
                  <?php echo($ligne["idAdherent"]);?>
              </option>
          <?php endforeach; ?>
      </select>
      <input type="submit" value="Valider">
      <fieldset style="visibility = <?php echo $visible2;?>">
        <label></label>
        <select name="rendu">
            <option value="0">--Veuillez selectionnez un adherent--</option>
            <?php foreach ($adherent as $ligne): ?>
                <option value="<?php echo($ligne["idAdherent"]);?>">
                    <?php echo($ligne["nomAdherent"]);?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Valider">
      </fieldset>
    </fieldset>
  </form>
  <!-- <a href="Emprunt_show.php">Retour</a> -->
</div>

<?php include ("v_foot.php");  ?>
