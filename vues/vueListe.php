<div class="Liste">
    <?php

    if (isset($_GET['getdelete']))
    {
        deleteInclut($_GET['getdelete'],$_GET['idLL']);
    }

    $ldl = getInfo($_GET['idLL']);

    $idLL = $ldl[0]['idLL'];
    $titre = $ldl[0]['Titre'];
    $versions = getVersionLL($idLL);
    $addduree = 0;

    echo "<h1>".$titre."</h1></br>";

    $i = 0;

    foreach($versions as $version)
    {
        $addduree += timeToSeconds($version['Durée']);
        $i++;
    }

    echo "<p>Durée : ".gmdate("H:i:s",$addduree)."  Nombre de musiques : ".$i."</p>";

    // if ($genre!='default')
    //     echo "<p>".pourcentageGenre($idLL,$genre)."% du genre ".nomGenre($genre)."</p>";
    ?>
    <a class="addButton" href='index.php?action=AddList<?php echo"&idLL=".$_GET['idLL'] ?>'>
        <img src="img/plus.svg">
        <p>Ajouter une musique</p>
    </a>
    <ul>
        <?php
        foreach($versions as $version)
        {
            echo "<li><a class='group' href='index.php?action=Musique&idC=".$version['idC']."'><img src='img/play.svg' /><p>".getTitreChanson($version['idC'])."</p></a><a class='trash' href='index.php?action=Liste&idLL=".$idLL."&getdelete=".$version['idC']."'><img src='img/Trash.svg' /></a></li>";
        }
        ?>
        <div class="PlaylistHeader">
            <?php echo "<a href='index.php?action=Compare&idLL=".$idLL."'>";?>
            <img src="img/Compare.svg">
            <p>Comparez 2 playlists</p>
            </a>
        </div>
    </ul>
</div>