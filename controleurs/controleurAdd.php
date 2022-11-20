<?php
if(isset($_POST['Ajouter']))
{
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $duree = $_POST['duree'];
    $nomFichier = $_POST['nomFichier'];
    $groupe = (int)$_POST['groupe'];
    $genre = (int)$_POST['genre'];
    addVersionsMusique($titre, $date, $duree, $nomFichier, $groupe, $genre);
}
$Groupes = getGroupes();
$Genres = getGenres();
?>