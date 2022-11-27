<?php

function makeRandomPlaylist($titre, $duree, $genre, $pref)
{
    $addduree = 0;
    postListesdeLecture($titre);

    // while ($duree >= $addduree)
    // {
    //     $versions = getVersion($genre);
    //     $nbVersion = count($versions);
    //     $nb = rand(0,$nbVersion-1);
        
    //     // $addduree += $versions[$nb]['durée'];
    // }
}

if(isset($_POST['Créer']))
{
    $titre = $_POST['titre'];
    $duree = $_POST['duree'];
    $genre = $_POST['genre'];
    $pref = $_POST['preference'];
    makeRandomPlaylist($titre, $duree, $genre, $pref);
}

$Genres = getGenres();

?>