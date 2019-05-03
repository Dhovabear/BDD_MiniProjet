<?php

function dateValide($texte){
    if(preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#",$texte,$matches)){
        if(checkdate($matches[2] , $matches[1] , $matches[3])){
            return "ok";
        }else{
            return "Veuillez entrer une date valide !";
        }
    }else {
        return "Veuillez entrer une date au format aaaa-mm-jj";
    }
}