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
                echo "<li><a href='index.php?action=Playlist&idLL=".$playlist['idLL']."'><p>".$playlist['Titre']."</p></a></li>";
            }
            ?>
        </ul>
    </div>
</div>