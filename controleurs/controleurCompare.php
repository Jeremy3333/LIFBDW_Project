<?php
    $playlists = getListesDeLecture();

    if(isset($_GET['idLL2']))
    {
        $versions = getVersionLL($_GET['idLL']);
        $versions2 = getVersionLL($_GET['idLL2']);

        $score = 0;

        $titres = 0;

        $addduree = 0;
        $addduree2 = 0;

        foreach($versions as $version)
        {
            foreach($versions2 as $version2)
            {
                $titres += getSimilarTitre($version['idC'],$version2['idC']);
                $addduree += timeToSeconds($version['Durée']);
                $addduree2 += timeToSeconds($version2['Durée']);
            }
        }

        if(count($versions) < count($versions2))
        {
            $score += count($versions) / count($versions2);
        }
        else
        {
            $score += count($versions2) / count($versions);
        }
        
        if($addduree < $addduree2)
        {
            $score += $addduree / $addduree2;
        }
        else
        {
            $score += $addduree2 / $addduree;
        }

        $score += 2 * ($titres / count($versions));

        $score += 6 * (getSimilarGenre($_GET['idLL'],$_GET['idLL2']));

        $score /= 10;

        header("Location: https://bdw.univ-lyon1.fr/p2103485/Rhyve/index.php?action=Liste&idLL=".$_GET['idLL']."&compare=".round($score,2));

    }
?>