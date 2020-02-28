<?php 

function redirect_to($location){
    if($location != null){
        header("Location: ".$location);
        exit;
    }
}

function randomChars($str, $numChars){
    //Return the characters.
    return substr(str_shuffle($str), 0, $numChars);
}