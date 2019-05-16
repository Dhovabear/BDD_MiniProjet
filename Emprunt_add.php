<?php
include ("connexion_bdd.php");

$commande = "SELECT * FROM ADHERENT ;";
$adherent = $bdd->query($commande)->fetchAll();

if (isset($_POST)){
  
}
?>
<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
  <form action="#" method="post">
    <fieldset>
      <label></label>
      <select name="adherent">
          <option value="0">--Veuillez selectionnez un adherent--</option>
          <?php foreach ($adherent as $ligne): ?>
              <option value="<?php echo($ligne["idAdherent"]);?>">
                  <?php echo($ligne["nomAdherent"]);?>
              </option>
          <?php endforeach; ?>
      </select>
      <input type="submit" value="Valider">
    </fieldset>
  </form>
  <!-- <a href="Emprunt_show.php">Retour</a> -->
</div>

<?php include ("v_foot.php");  ?>
