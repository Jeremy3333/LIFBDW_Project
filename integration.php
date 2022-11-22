<?php
include('modele/modele.php');

$datas = getRowData();
foreach($datas as $data)
{
    postGroupe($data['artist']);
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
        postGenre($genre);
        postCaracterise($data['title'], $genre);
    }
    postVersionsMusique($data['title'], gmdate("H:i:s", $data['length']), $data['filename'], $data['artist']);
}
?>