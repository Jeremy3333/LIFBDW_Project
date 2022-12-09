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
            $versionsLL = getVersionLL($idLL);
            $nbVersion = count($versionsLL);
            $nbs = rand(0,$nbVersion-1);
            deleteInclut($versionsLL[$nbs]['idC'],$idLL);
            $addduree = $addduree - timeToSeconds($versionsLL[$nbs]['Durée']);
        }
    }

    $info = array(
        'duree' => $addduree,
        'idLL' => $idLL,
        'genre' => $genre,
    );

    return $info;
}


if(isset($_POST['Créer']))
{
    $titre = $_POST['titre'];
    $duree = $_POST['duree'];
    $genre = $_POST['genre'];
    $pref = $_POST['preference'];
    $info = makeRandomPlaylist($titre, $duree, $genre, $pref);
}

$Genres = getGenres();
?>