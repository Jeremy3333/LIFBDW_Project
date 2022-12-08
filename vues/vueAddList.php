<div class="Musiques">
    <ul>
        <?php
        foreach($chansons as $chanson)
        {
            echo "<li><a href='index.php?action=Liste&idLL=".$idLL."&AddList=".$chanson['idC']."'><img src='img/plus.svg' /><p>".$chanson["Titre"] . "</p></a></li>";
        }
        ?>
    </ul>
</div>