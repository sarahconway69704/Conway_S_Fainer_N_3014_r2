<?php 

function redirect_to($location){
    if($location != null){
        header("Location: ".$location);
        exit;
    }
}

function randString($str, $numString){
    return substr(str_shuffle($str), 0, $numString);
}