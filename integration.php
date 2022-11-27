<?php
include('modele/modele.php');

$bdd = getBdd();
$datas = getRowData($bdd);
$username = "p2103485";
$bdd -> select_db($username);
foreach($datas as $data)
{
    $idGM = postGroupe($data['artist'], $bdd);
    $idC = postChansons($data['title'], $data['year'], $idGM, $bdd);
    $idV = postVersionsMusique($idC, $data['length'], $data['filename'], $bdd);
    $idA = postAlbums($data['album'], $data['year'], $bdd);
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
        $idG = postGenres($genre, $bdd);
        postCaracterise($idC, $idG, $bdd);
    }
    postPossède($idC, $idV, $idA, $data['track'], $bdd);
    postComporte($idC, $idV, "Compilation", $data['compilation'], $bdd);
    postComporte($idC, $idV, "filesize", $data['filesize'], $bdd);
    postComporte($idC, $idV, "playcount", $data['playcount'], $bdd);
    postComporte($idC, $idV, "lastplayed", $data['lastplayed'], $bdd);
    postComporte($idC, $idV, "skipcount", $data['skipcount'], $bdd);
}
mysqli_close($bdd);
?>