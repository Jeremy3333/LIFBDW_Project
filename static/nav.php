<nav>
    <ul>
        <?php
        // verify which page is active
        $active = '';
        if (isset($_GET['action'])) {
            $active = $_GET['action'];
        }
        if($active == '')
        {
            echo '<li><a href="index.php" class="selected"><img src="img/accueil.svg"><p>Accueil</p></a></li>';
            echo '<li><a href="index.php?action=Statistique"><img src="img/statistiqueDark.svg"><p>Statistique</p></a></li>';
            echo '<li><a href="index.php?action=Add"><img src="img/addDark.svg"><p>Ajouter une musique</p></a></li>';
            echo '<li><a href="index.php?action=Playlist"><img src="img/playlistDark.svg"><p>Playlist</p></a></li>';
            echo '<li><a href="index.php?action=Musique"><img src="img/musicalDark.svg"><p>Musique</p></a></li>';
        }
        elseif($active == 'Statistique')
        {
            echo '<li><a href="index.php"><img src="img/accueilDark.svg"><p>Accueil</p></a></li>';
            echo '<li><a href="index.php?action=Statistique" class="selected"><img src="img/statistique.svg"><p>Statistique</p></a></li>';
            echo '<li><a href="index.php?action=Add"><img src="img/addDark.svg"><p>Ajouter une musique</p></a></li>';
            echo '<li><a href="index.php?action=Playlist"><img src="img/playlistDark.svg"><p>Playlist</p></a></li>';
            echo '<li><a href="index.php?action=Musique"><img src="img/musicalDark.svg"><p>Musique</p></a></li>';
        }
        elseif($active == 'Add')
        {
            echo '<li><a href="index.php"><img src="img/accueilDark.svg"><p>Accueil</p></a></li>';
            echo '<li><a href="index.php?action=Statistique"><img src="img/statistiqueDark.svg"><p>Statistique</p></a></li>';
            echo '<li><a href="index.php?action=Add" class="selected"><img src="img/add.svg"><p>Ajouter une musique</p></a></li>';
            echo '<li><a href="index.php?action=Playlist"><img src="img/playlistDark.svg"><p>Playlist</p></a></li>';
            echo '<li><a href="index.php?action=Musique"><img src="img/musicalDark.svg"><p>Musique</p></a></li>';
        }
        elseif($active == 'Playlist')
        {
            echo '<li><a href="index.php"><img src="img/accueilDark.svg"><p>Accueil</p></a></li>';
            echo '<li><a href="index.php?action=Statistique"><img src="img/statistiqueDark.svg"><p>Statistique</p></a></li>';
            echo '<li><a href="index.php?action=Add"><img src="img/addDark.svg"><p>Ajouter une musique</p></a></li>';
            echo '<li><a href="index.php?action=Playlist" class="selected"><img src="img/playlist.svg"><p>Playlist</p></a></li>';
            echo '<li><a href="index.php?action=Musique"><img src="img/musicalDark.svg"><p>Musique</p></a></li>';
        }
        elseif($active == 'Musique')
        {
            echo '<li><a href="index.php"><img src="img/accueilDark.svg"><p>Accueil</p></a></li>';
            echo '<li><a href="index.php?action=Statistique"><img src="img/statistiqueDark.svg"><p>Statistique</p></a></li>';
            echo '<li><a href="index.php?action=Add"><img src="img/addDark.svg"><p>Ajouter une musique</p></a></li>';
            echo '<li><a href="index.php?action=Playlist"><img src="img/playlistDark.svg"><p>Playlist</p></a></li>';
            echo '<li><a href="index.php?action=Musique" class="selected"><img src="img/musical.svg"><p>Musique</p></a></li>';
        }
        else
        {
            echo '<li><a href="index.php"><img src="img/accueilDark.svg"><p>Accueil</p></a></li>';
            echo '<li><a href="index.php?action=Statistique"><img src="img/statistiqueDark.svg"><p>Statistique</p></a></li>';
            echo '<li><a href="index.php?action=Add"><img src="img/addDark.svg"><p>Ajouter une musique</p></a></li>';
            echo '<li><a href="index.php?action=Playlist"><img src="img/playlistDark.svg"><p>Playlist</p></a></li>';
            echo '<li><a href="index.php?action=Musique"><img src="img/musicalDark.svg"><p>Musique</p></a></li>';
        }
        ?>
    </ul>
</nav>