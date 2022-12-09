<div class="Playlist">
    <div class="PlaylistBody">
        <ul>
            <?php
            foreach($playlists as $playlist)
            {
                if($playlist['idLL'] != $_GET['idLL'])
                    echo "<li><a href='index.php?action=Compare&idLL=".$_GET['idLL']."&idLL2=".$playlist['idLL']."'><img src='img/Compare.svg' /><p>"." ".$playlist['Titre']."</p></a></li>";
            }
            ?>
        </ul>
    </div>
</div>