<div class="Form">
    <form method="post" action="index.php?action=playlistRandom">
        <label for="titre">Nom de la playlist</label>
        <input type="text" name="titre" id="titre" placeholder="Nom de la playlist" required/>
        <label for="duree">Durée (Bien séparer les informtions par ':' et penser à mettre les 2 chifrres)</label>
        <input type="text" pattern="([0-5]{1}[0-9]{1}:){0,2}[0-5]{0,1}[0-9]{1}(\.\d+)?" name="duree" id="duree" value="00:20:00" required/>
        <label for="genre">Genre</label>
        <select name="genre" id="genre">
            <option value="default">Aucun genre priviligié</option>
            <?php
            foreach($Genres as $genre)
            {
                echo '<option value="'.$genre['idG'].'">'.$genre['Genre'].'</option>';
            }
            ?>
        </select>
        <label for="preference">Préférence</label>
        <select name="preference" id="preference">
            <option value="default">Pas de préférence</option>
            <option value="playcount">Les plus jouées</option>
            <option value="skipcount">Les plus sautées</option>
            <option value="lastplayed">Les plus récentes</option>
        </select>
        <input type="submit" name="Créer" value="Créer" />
    </form>
    <div class="info">
    <?php
    if(isset($info))
    {
        echo "<p>".$titre."</p>";

        echo "<p>La playlist dure : ".gmdate("H:i:s",$info['duree'])."</p>";

        if ($info['genre'] != 'default')
        {
            echo "<p>La playlist comorte : ".pourcentageGenre($info['idLL'],$info['genre'])."% du genre ".nomGenre($info['genre'])."</p>";
            if(pourcentageGenre($info['idLL'],$info['genre'])<50)
                echo "<p>Il n'y a pas assez de chanson du genre priviligié dans la base de donnée par rapport à la durée de la playlist</p>";

        }
    }
    ?>
    </div>
</div>