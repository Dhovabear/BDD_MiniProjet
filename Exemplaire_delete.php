<?php
/**
 * Created by PhpStorm.
 * User: kvuillau
 * Date: 16/05/19
 * Time: 08:33
 */

include "connexion_bdd.php";

if(isset($_GET["idToDel"]) && isset($_GET["noOeuvre"])){
    $commande = "DELETE FROM EXEMPLAIRE WHERE EXEMPLAIRE.noExemplaire = ".$_GET["idToDel"];
    $res = $bdd->exec($commande);
    header("Location: Exemplaire_show.php?noOeuvre=".$_GET["noOeuvre"]."&delSuc=".$res);
}