<?php

function makeRandomPlaylist($duree, $genre, $pref)
{
    $addduree = 0;

    while ($duree >= $addduree)
    {
        $versions = getVersion($genre);
        $nbVersion = count($versions);
        $nb = rand(0,$nbVersion-1);
        postListesdeLecture($versions[$nb]);
        $addduree += $versions[$nb]['durée'];
    }
}

if(isset($_POST['Créer']))
{
    $duree = $_POST['duree'];
    $genre = $_POST['genre'];
    $pref = $_POST['preference'];
    makeRandomPlaylist($duree, $genre, $pref);
}

$Genres = getGenres();

?>