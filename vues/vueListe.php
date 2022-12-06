<div class="Musiques">
    <?php 
    
    echo "<h1>".$titre."</h1></br>";

    echo "<p>Durée : ".gmdate("H:i:s",$addduree)."</p>";

    if ($genre!='default')
        echo "<p>".pourcentageGenre($idLL,$genre)."% du genre ".nomGenre($genre)."</p>";
    ?>
    <ul>
        <?php
        foreach($chansons as $chanson)
        {
            echo "<li><a href='index.php?action=Musique&idC=".$chanson['idC']."'><img src='img/play.svg' /><p>".$chanson["Titre"] . "</p></a></li>";
        }
        ?>
    </ul>
</div>