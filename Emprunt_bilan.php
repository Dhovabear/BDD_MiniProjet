<?php
include ("connexion_bdd.php");
$adPost = 3;
$commandeBilan = "SELECT ADHERENT.nomAdherent, OEUVRE.titre, EMPRUNT.dateEmprunt
                , COUNT(EXEMPLAIRE.noExemplaire) as nbrEx
                FROM EXEMPLAIRE
                INNER JOIN OEUVRE ON ADHERENT.idAdherent = EMPRUNT.idAdherent
                INNER JOIN EXEMPLAIRE ON EMPRUNT.noExemplaire = EXEMPLAIRE.noExemplaire
                INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre;";
  // $commandeBilan = $commandeBilan."WHERE ADHERENT.idAdherent =  GROUP BY OEUVRE.noOeuvre ;";
  // ".$adPost."

$empr = $bdd->query($commandeBilan)->fetchAll();
?>
<table border="1">
  <th>titre</th><th>date Emprunt</th><th>Exemplaire</th>
  <?php foreach($empr as $row): ?>
      <?php
          echo "<tr><td>".$row['titre']."</td><td>".$row['dateEmprunt']."</td><td>".$row['nbrEx']."</td>" ?>
  <?php endforeach;?>
</table>
