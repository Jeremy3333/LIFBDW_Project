<div class="Form">
    <form method="post" action="index.php?action=playlistRandom">
        <label for="duree">Durée</label>
        <input type="time" name="duree" id="duree" placeholder="Durée" require/>
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
</div>