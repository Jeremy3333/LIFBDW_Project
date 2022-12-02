<div class="Musiques">
    <ul>
        <?php
        foreach($chansons as $chanson)
        {
            echo "<li><a href='index.php?action=Musique&idC=".$chanson['idC']."'><img src='img/play.svg' /><p>".$chanson["Titre"] . "</p></a></li>";
        }
        ?>
    </ul>
</div>