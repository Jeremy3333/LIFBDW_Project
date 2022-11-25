<?php

function makeRandomPlaylist($duree, $genre, $pref)
{
    
}

if(isset($_POST['Créer']))
{
    $duree = $_POST['duree'];
    $genre = $_POST['genre'];
    $pref = $_POST['preference'];
    // makeRandomPlaylist($duree, $genre, $pref);
}
$Genres = getGenres();
?>