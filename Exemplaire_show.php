<?php
include("connexion_bdd.php");




// traitement
if(isset($_POST)  )  // si il existe certaines variables dans le tableau associatif $_POST
{                    // le formulaire vient d'être soumis

}

$numOeuvre = 0;

if(isset($_GET)){
    if(isset($_GET["noOeuvre"])){
        $numOeuvre = $_GET["noOeuvre"];
    }
}


$commande = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noOeuvre = ".$bdd->quote($numOeuvre).";";
$exemplaires = $bdd->query($commande)->fetchAll();

$commande = "SELECT * FROM OEUVRE WHERE OEUVRE.noOeuvre = ".$bdd->quote($numOeuvre).";";
$oeuvre = $bdd->query($commande)->fetch();

// affichage de la vue
?>
<?php include("v_head.php");  ?>
<?php include ("v_nav.php");  ?>

<!-- affichage(vue) relatif à la page -->


<div class="row">
    <div class="titreMenu">Exemplaires de l'oeuvre '<?php echo($oeuvre["titre"]) ?>' </div>
    <table border="2">
        <caption>Liste des exemplaires</caption>
        <thead>
            <tr>
                <th>N exemplaire</th><th>etat</th>
                <th>date achat</th><th>prix</th><th>opérations</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<?php include ("v_foot.php");  ?>
