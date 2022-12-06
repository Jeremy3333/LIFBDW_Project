<?php
function makeRandomPlaylist($titre, $duree, $genre, $pref)
{
    $addduree = 0;
    $i = 1;
    $idLL = postListesdeLecture($titre);
    $timepl = timeToSeconds($duree);

    while ($timepl-60 >= $addduree or $timepl+60 <= $addduree)
    {
        if ($genre=='default')
            $i=4;
        
        if($pref=='default')
        {
            if($i==4)
            {
                $versions = getVersionAll();
                $i=1;
            }
            else
            {
                $versions = getVersionByGenre($genre);
                $i++;
            }
        }
        else
        {
            if($i==4)
            {
                $versions = getVersionAllByPref($pref,round($timepl/200));
                $i=1;
            }
            else
            {
                $versions = getVersionByGenreAndPref($genre,$pref,round($timepl/200));
                $i++;
            }
        }

        $nbVersion = count($versions);
        $nb = rand(0,$nbVersion-1);
        postInclut($idLL,$versions[$nb]['idV'],$versions[$nb]['idC']);

        $addduree += timeToSeconds($versions[$nb]['Durée']);

        if($timepl+60 < $addduree)
        {
            $versions = getVersionLL($idLL);
            $nbVersion = count($versions);
            $nbs = rand(0,$nbVersion-1);
            deleteInclut($versions[$nbs]['idC'],$idLL);
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