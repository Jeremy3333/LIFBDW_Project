<div class="Add">
    <form method="post" action="index.php?action=Add">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" placeholder="Titre" require/>
        <label for="date">Date</label>
        <input type="date" name="date" id="date" placeholder="Date" require/>
        <label for="duree">Durée</label>
        <input type="time" name="duree" id="duree" placeholder="Durée" require/>
        <label for="nomFichier">Nom du fichier</label>
        <input type="text" name="nomFichier" id="nomFichier" placeholder="Nom du fichier" require/>
        <label for="groupe">Groupe</label>
        <select name="groupe" id="groupe">
            <?php
            foreach($Groupes as $groupe)
            {
                echo '<option value="'.$groupe['idGM'].'">'.$groupe['Nom'].'</option>';
            }
            ?>
        </select>
        <label for="genre">Genre</label>
        <select name="genre" id="genre">
            <?php
            foreach($Genres as $genre)
            {
                echo '<option value="'.$genre['idG'].'">'.$genre['Genre'].'</option>';
            }
            ?>
        </select>
        <input type="submit"name="Ajouter" value="Ajouter" />
    </form>
</div>