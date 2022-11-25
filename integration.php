<?php
include('modele/modele.php');

$datas = getRowData();
foreach($datas as $data)
{
    $idGM = postGroupe($data['artist']);
    $idC = postChansons($data['title'], $data['year'], $idGM);
    $idV = postVersionsMusique($idC, $data['length'], $data['filename']);
    $idA = postAlbums($data['album'], $data['year']);
    $genres =  $data['genre'];
    // if genre have "; " or " / " then explode it
    if (strpos($genres, "; ") !== false) {
        $genres = explode("; ", $genres);
    } elseif (strpos($genres, " / ") !== false) {
        $genres = explode(" / ", $genres);
    } elseif (strpos($genres, " And ") !== false) {
        $genres = explode(" And ", $genres);
    } else {
        $genres = array($genres);
    }
    foreach($genres as $genre)
    {
        $idG = postGenres($genre);
        postCaracterise($idC, $idG);
    }
    postPossède($idC, $idV, $idA, $data['track']);
    // postVersionsMusique($data['title'], gmdate("H:i:s", $data['length']), $data['filename'], $data['artist']);
}
?>