<?php
function timeToSeconds(string $time)
{
    $arr = explode(':', $time);
    if (count($arr) === 3) {
        return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
    }
    return $arr[0] * 60 + $arr[1];
}



function makeRandomPlaylist($titre, $duree, $genre, $pref)
{
    $addduree = 0;
    $i = 1;
    postListesdeLecture($titre);
    $idLL = getidLL();
    $timepl = timeToSeconds($duree);

    while ($timepl-60 >= $addduree or $timepl+60 <= $addduree)
    {
        if ($genre=='default')
            $i=4;

        if($i==4)
        {
            $versions = getVersionAll();
            $i=0;
        }
        else
        {
            $versions = getVersion($genre);
            $i++;
        }

        $nbVersion = count($versions);
        $nb = rand(0,$nbVersion-1);
        postInclut($idLL,$versions[$nb]['idV']);

        $addduree += timeToSeconds($versions[$nb]['Durée']);

        if($timepl+60 < $addduree)
        {
            $versions = getVersionLL($idLL);
            $nbVersion = count($versions);
            $nbs = rand(0,$nbVersion-1);
            deleteInclut($versions[$nbs]['idV'],$idLL);
            $addduree -= timeToSeconds($versions[$nbs]['Durée']);
        }
    }

    echo "<p>".$titre."</p>";

    echo "<p>La playlist dure : ".gmdate("H:i:s",$addduree)."</p>";

    if ($genre!='default')
        echo "<p>La playlist comorte : ".pourcentageGenre($idLL,$genre)."% du genre ".nomGenre($genre)."</p>";
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