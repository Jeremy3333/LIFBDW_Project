<?php
function timeToSeconds(string $time)
{
    $arr = explode(':', $time);
    // if (count($arr) === 3) {
    //     return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
    // }
    return $arr[0] * 60 + $arr[1];
}

function makeRandomPlaylist($titre, $duree, $genre, $pref)
{
    $addduree = 0;
    $idLL = postListesdeLecture($titre);
    $timepl = timeToSeconds($duree);

    while ($timepl-60 >= $addduree or $timepl+60 <= $addduree)
    {
        $versions = getVersion($genre);
        $nbVersion = count($versions);
        $nb = rand(0,$nbVersion-1);
        postInclut($idLL,$versions[$nb]['idV']);

        $addduree += timeToSeconds($versions[$nb]['Durée']);

        if($timepl+60 < $addduree)
        {
            deleteInclut($idLL);
            $addduree =0;
        }
    }
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