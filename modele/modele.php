<?php
function addVersionsMusique($titre, $date, $durée, $nomFichier, $groupe, $genre)
{
    $bdd = getBdd();
    $req = $bdd->prepare('INSERT INTO versions_musique(titre, date, durée, nomFichier, groupe, genre) VALUES(:titre, :date, :durée, :nomFichier, :groupe, :genre)');
    $req->execute(array(
        'titre' => $titre,
        'date' => $date,
        'durée' => $durée,
        'nomFichier' => $nomFichier,
        'groupe' => $groupe,
        'genre' => $genre
    ));
    $req->closeCursor();
}
?>