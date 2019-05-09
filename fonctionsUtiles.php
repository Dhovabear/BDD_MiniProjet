<?php

function dateValide($texte){
    if(preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#",$texte,$matches)){
        if(checkdate($matches[2] , $matches[1] , $matches[3])){
            return $matches[3]."-".$matches[2]."-".$matches[1];
        }else{
            return "Veuillez entrer une date valide !";
        }
    }else {
        return "Veuillez entrer une date au format jj/mm/aaaa";
    }
}


function dateBddToFr($texte){
    if(preg_match("#^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$#",$texte,$matches)){
        if(checkdate($matches[2] , $matches[3] , $matches[1])){
            return $matches[3]."/".$matches[2]."/".$matches[1];
        }
    }
}

function texteValide($texte){
  $textSansEspace = (str_replace(" ","",$texte) );
  if( ($textSansEspace == '') or ( strlen(str_replace(" ","",$texte))< 2)){
    return "Veuillez rentrer un texte de plus de deux charactère, espace exclus";
  }else{
    return $texte;
  }
}
