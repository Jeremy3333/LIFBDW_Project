 <div class="Playlist">
    <div class="PlaylistHeader">
        <a href='index.php?action=playlistRandom'>
        <img src="img/plus.svg">
        <p>Créer une playlist aléatoire</p>
        </a>
    </div>
    <div class="PlaylistBody">
        <ul>
            <?php
            foreach($playlists as $playlist)
            {
                $versions = getVersionLL($playlist['idLL']);

                $addduree = 0;

                foreach($versions as $version)
                {
                    $addduree += timeToSeconds($version['Durée']);
                }
                
                echo "<li><a href='index.php?action=Liste&idLL=".$playlist['idLL']."'><img src='img/LdL.svg' /><p>"." ".$playlist['Titre']."</br>".count($versions)." Titre(s) ".gmdate("H:i:s",$addduree)."</p></a></li>";
            }
            ?>
        </ul>
    </div>
</div>