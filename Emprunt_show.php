<?php
include ("connexion_bdd.php");
include ("fonctionsUtiles.php");


$add ="";
if(isset($_POST['supr'])){//to run PHP script on submit
  $spr = $_POST['supr'];
  if(!empty($spr)){
    foreach($spr as $sele){
        $commande9 = "DELETE FROM EMPRUNT WHERE noExemplaire ='{$sele}'";
        $empr = $bdd->exec($commande9);
    }
  }
}

$commandeBilan = "SELECT ADHERENT.nomAdherent, OEUVRE.titre, EMPRUNT.dateEmprunt, EXEMPLAIRE.noExemplaire
FROM EMPRUNT
INNER JOIN ADHERENT ON ADHERENT.idAdherent = EMPRUNT.idAdherent
INNER JOIN EXEMPLAIRE ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre;";

$empr = $bdd->query($commandeBilan)->fetchAll();

?>

<?php include ("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
  <form action="#" method="post">
    <input type="submit" name="validerDeleteAll" id="valider" value="supprimer">
    tout sélectionner ? <input type="checkbox" onclick="toggle(this);" /><br />
    <table border="1">
      <th>Adhérent</th><th>titre</th><th>date Emprunt</th>
      <?php foreach($empr as $row): ?>
          <?php echo "<tr><td>".$row['nomAdherent']."</td><td>".$row['titre']."</td><td>".$row['dateEmprunt']."</td><td><input type='checkbox' name='supr[]' value='".$row['noExemplaire']."' </input></td>";?>
      <?php endforeach;?>
    </table>
  </form>
</div>

    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

    </script>

<?php include ("v_foot.php");  ?>
