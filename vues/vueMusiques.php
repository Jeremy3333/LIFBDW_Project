<div class="Musiques">
    <ul>
        <?php
        foreach($chansons as $chanson)
        {
            echo "<li><a href='index.php?action=Musique&idC=".$chanson['idC']."'><p>".$chanson["Titre"] . "</p></a></li>";
        }
        ?>
    </ul>
</div>