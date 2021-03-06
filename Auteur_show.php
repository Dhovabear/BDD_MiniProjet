<?php
include("connexion_bdd.php");
// traitement

$smthgWasDel = false;
$smthgWasAdd = false;
$smthgWasEdit = false;

if (isset($_GET)){
    if(isset($_GET["delSuc"])){
        $smthgWasDel = true;
    }
    if(isset($_GET["addSuc"])){
        $smthgWasAdd = true;
    }

    if(isset($_GET["editSuc"])){
        $smthgWasEdit = true;
    }
}

if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
}

$commande = "SELECT AUTEUR.idAuteur , AUTEUR.nomAuteur , AUTEUR.prenomAuteur , COUNT(OEUVRE.idAuteur) AS nbrOeuvres FROM AUTEUR
             LEFT JOIN OEUVRE ON AUTEUR.idAuteur = OEUVRE.idAuteur
             GROUP BY AUTEUR.idAuteur;";
$auteurs = $bdd->query($commande)->fetchAll();

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
    <div class="titreMenu"> Liste des auteurs enregistrés</div>
    <?php if($smthgWasDel): ?>
        <?php if($_GET["delSuc"]): ?>
            <div class="titreMenu" style="color: green">Suppression réussie !</div>
        <?php else: ?>
            <div class="titreMenu" style="color: red">Echec lors de la suppression</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($smthgWasAdd): ?>
        <?php if($_GET["addSuc"]): ?>
            <div class="titreMenu" style="color: green">Ajout réussie !</div>
        <?php else: ?>
            <div class="titreMenu" style="color: red">Echec lors de l'ajout</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($smthgWasEdit): ?>
        <?php if($_GET["editSuc"]): ?>
            <div class="titreMenu" style="color: green">Modifications enregistrées !</div>
        <?php else: ?>
            <div class="titreMenu" style="color: red">Echec lors de l'enregistrement des modifications</div>
        <?php endif; ?>
    <?php endif; ?>

    <a href="Auteur_add.php">Ajouter un auteur</a>
    <?php if(isset($auteurs[0])): ?>
        <table border="2">
            <caption>Liste des auteurs</caption>
            <thead>
                <tr><th>nom de l'auteur</th><th>prenom de l'auteur</th><th>Nombre d'oeuvres</th><th>actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($auteurs as $ligne ): ?>
                    <tr>
                        <td><?php echo($ligne["nomAuteur"]); ?></td>
                        <td><?php echo($ligne["prenomAuteur"]); ?></td>
                        <td>
                            <?php echo($ligne["nbrOeuvres"]); ?>
                        </td>
                        <td>
                            <a href="Auteur_delete.php?idToDel=<?php echo($ligne["idAuteur"]) ?>">Supprimer</a>
                            <a href="Auteur_edit.php?idToEdit=<?php echo($ligne["idAuteur"]) ?>">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="erreur">Aucun auteur enregistré dans la base de donnée</div>
    <?php endif; ?>
</div>
<!-- affichage(vue) relatif à la page -->

<?php include ("v_foot.php");  ?>
