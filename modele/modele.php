<?php
include('inc/includes.php');
function getBdd()
{
    $servername = "localhost";
    $username = "p2103485";
    $password = "Salon17Spree";
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
function addVersionsMusique($titre, $date, $durée, $nomFichier, $groupe, $genre)
{
    $username = "p2103485";
    $bdd = getBdd();
    if(!(isset($titre) && is_string($titre) && isset($date) && is_string($date) && isset($durée) && is_string($durée) && isset($nomFichier) && is_string($nomFichier) && isset($groupe) && is_integer($groupe) && isset($genre) && is_integer($genre)))
    {
        return false;
    }
    $titre = $bdd->real_escape_string($titre);
    $date = $bdd->real_escape_string($date);
    $durée = $bdd->real_escape_string($durée);
    $nomFichier = $bdd->real_escape_string($nomFichier);
    $groupe = $bdd->real_escape_string($groupe);
    $genre = $bdd->real_escape_string($genre);
    $bdd -> select_db($username);
    // check the idC and idGM in Chansons table where the title have the same begining as the title of the song (let only the part that is not in the title of the song)
    $sql = "SELECT idC, idGM, Titre FROM Chansons WHERE '$titre' LIKE CONCAT(Titre, '%') ";
    $result = $bdd->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $idC = $row["idC"];
            $idGM = $row["idGM"];
            $len = strlen($row["Titre"]);
            $titre = substr($titre, $len);
        }
    } else {
        $idC = 0;
        $idGM = $groupe;
    }
    // if the idC is 0, it means that the song is not in the database, so we add it
    if($idC == 0)
    {
        // check the last idC in the Chansons table
        $sql = "SELECT MAX(idC) FROM VersionsMusique";
        $result = $bdd->query($sql);
        $row = $result->fetch_assoc();
        $idC = $row['MAX(idC)'] + 1;
        // add the song in the Chansons table
        $sql = "INSERT INTO Chansons VALUES ('$idGM', '$idC', '$titre', '$date')";
        mysqli_query($bdd, $sql);
    }
    // check what's the last id of the VersionsMusique table
    $sql = "SELECT MAX(idV) FROM VersionsMusique";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idV = $row['MAX(idV)'] + 1;
    $req_mus = "INSERT INTO VersionsMusique VALUES('$idGM', '$idC', '$idV', '$titre', '$durée', '$nomFichier')";
    mysqli_query($bdd, $req_mus);
    // if the idGM isn't equal to groupe , it means that the versions is a reprise, so we add it
    if($idGM != $groupe)
    {
        $req_mus = "INSERT INTO Repris VALUES('$groupe', '$idGM', '$idC', '$idV')";
        mysqli_query($bdd, $req_mus);
        //check error and print it
        if (mysqli_errno($bdd)) {
            $error = mysqli_error($bdd);
            echo $error;
        }
    }
    //close connection
    mysqli_close($bdd);
}
function getGroupes()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT * FROM GroupeMusique";
    $result = mysqli_query($bdd, $req_groupe);
    //check if query successful
    if(!$result)
    {
        printf("Error: %s\n", mysqli_error($bdd));
    }
    $groupes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $groupes;
}
function getGenres()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT * FROM Genres";
    $result = mysqli_query($bdd, $req_groupe);
    //check if query successful
    if(!$result)
    {
        printf("Error: %s\n", mysqli_error($bdd));
    }
    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $genres;
}
?>