<div class="Musiques">
    <?php 

    $ldl = getInfo($_GET['idLL']);

    $idLL = $ldl[0]['idLL'];
    $titre = $ldl[0]['Titre'];
    $versions = getVersionLL($idLL);
    $addduree = 0;
    
    echo "<h1>".$titre."</h1></br>";

    foreach($versions as $version)
    {
        $addduree += timeToSeconds($version['Durée']);
    }

    echo "<p>Durée : ".gmdate("H:i:s",$addduree)."</p>";

    // if ($genre!='default')
    //     echo "<p>".pourcentageGenre($idLL,$genre)."% du genre ".nomGenre($genre)."</p>";
    ?>
    <ul>
        <?php
        foreach($versions as $version)
        {
            echo "<li><a href='index.php?action=Musique&idC=".$version['idC']."'><img src='img/play.svg' /><p>".getTitreChanson($version['idC'])."</p></a></li>";
        }
        ?>
    </ul>
</div>