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
