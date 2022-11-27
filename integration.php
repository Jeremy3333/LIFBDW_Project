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
    postPossède($idC, $idV, $idA, $data['track'], $bdd);
    postCompilation($idC, $idV, $data['compilation'], $bdd);
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
}
mysqli_close($bdd);
?>