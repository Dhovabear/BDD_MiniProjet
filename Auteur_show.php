<?php
include("connexion_bdd.php");
// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis
    $commande = "SELECT * FROM AUTEUR;";
    $auteurs = $bdd->query($commande)->fetchAll();
}

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<div class="row">
    <a href="Auteur_add.php">Ajouter un auteur</a>
    <?php if(isset($auteurs[0])): ?>
        <table border="2">
            <caption>Liste des auteurs</caption>
            <thead>
                <tr><th>nom de l'auteur</th><th>prenom de l'auteur</th><th>actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($auteurs as $ligne ): ?>
                    <tr>
                        <td><?php echo($ligne["nomAuteur"]); ?></td>
                        <td><?php echo($ligne["prenomAuteur"]); ?></td>
                        <td><a href="Auteur_delete.php">Supprimer</a></td>
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
