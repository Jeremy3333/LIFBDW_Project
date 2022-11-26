<?php
//include('inc/includes.php');
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
        }
    } else {
        $idC = 0;
        $idGM = $groupe;
    }
    // if the idC is 0, it means that the song is not in the database, so we add it
    if($idC == 0)
    {
        // check the last idC in the Chansons table
        $sql = "SELECT MAX(idC) FROM Chansons";
        $result = $bdd->query($sql);
        $row = $result->fetch_assoc();
        $idC = $row['MAX(idC)'] + 1;
        // add the song in the Chansons table
        $sql = "INSERT INTO Chansons VALUES ('$idC', '$groupe', '$titre', '$date')";
        mysqli_query($bdd, $sql);
    }
    // check what's the last id of the VersionsMusique table
    $sql = "SELECT MAX(idV) FROM VersionsMusique";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idV = $row['MAX(idV)'] + 1;
    $req_mus = "INSERT INTO VersionsMusique VALUES('$idC', '$idV', '$titre', '$durée', '$nomFichier')";
    mysqli_query($bdd, $req_mus);
    // if the idGM isn't equal to groupe , it means that the versions is a reprise, so we add it
    if($idGM != $groupe)
    {
        $req_mus = "INSERT INTO Repris VALUES('$groupe', '$idC', '$idV')";
        mysqli_query($bdd, $req_mus);
    }
    $sql = "SELECT idG FROM Caractérise WHERE '$idC' = idC AND '$genre' = idG";
    $result = $bdd->query($sql);
    if ($result->num_rows == 0) {
        $req_mus = "INSERT INTO Caractérise VALUES('$idC', '$genre')";
        mysqli_query($bdd, $req_mus);
    }
    //close connection
    mysqli_close($bdd);
}
function postGroupe($nom, $bdd)
{
    $nom = $bdd->real_escape_string($nom);

    $sql = "SELECT idGM FROM GroupeMusique WHERE Nom = '$nom'";
    $result = $bdd->query($sql);
    $groupes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return $groupes[0]['idGM'];
    }

    $sql = "INSERT INTO GroupeMusique(Nom) VALUES ('$nom')";
    mysqli_query($bdd, $sql);
    $idGM = mysqli_insert_id($bdd);
    return $idGM;
}
function postChansons($titre, $year, $idGM, $bdd)
{
    $titre = $bdd->real_escape_string($titre);
    $year = $bdd->real_escape_string($year);
    $idGM = $bdd->real_escape_string($idGM);

    $sql = "SELECT idC FROM Chansons WHERE Titre = '$titre' AND idGM = '$idGM'";
    $result = $bdd->query($sql);
    $chansons = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return $chansons[0]['idC'];
    }

    //convert year to date
    $date = $year . "-01-01";

    if($year == -1)
    {
        $sql = "INSERT INTO Chansons(idGM, Titre) VALUES ('$idGM', '$titre')";
    }
    else
    {
        $sql = "INSERT INTO Chansons(idGM, Titre, DateCréation) VALUES ('$idGM', '$titre', '$date')";
    }

    mysqli_query($bdd, $sql);
    $idC = mysqli_insert_id($bdd);
    return $idC;
}
function postVersionsMusique($idC, $seconds, $filename, $bdd)
{
    $idC = $bdd->real_escape_string($idC);
    $seconds = $bdd->real_escape_string($seconds);
    $filename = $bdd->real_escape_string($filename);

    $sql = "SELECT idV FROM VersionsMusique WHERE idC = '$idC' AND Fichier = '$filename'";
    $result = $bdd->query($sql);
    $versions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return $versions[0]['idV'];
    }

    // Check the last idV with that idC
    $sql = "SELECT MAX(idV) FROM VersionsMusique WHERE idC = '$idC'";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idV = $row['MAX(idV)'] + 1;

    //convert seconds to time
    $time = gmdate("H:i:s", $seconds);

    $sql = "INSERT INTO VersionsMusique(idC, idV, Durée, Fichier) VALUES ('$idC', '$idV', '$time', '$filename')";
    mysqli_query($bdd, $sql);
    $idV = mysqli_insert_id($bdd);
    return $idV;
}
function postAlbums($titre, $year, $bdd)
{
    $titre = $bdd->real_escape_string($titre);
    $year = $bdd->real_escape_string($year);

    $sql = "SELECT idA FROM Albums WHERE Titre = '$titre'";
    $result = $bdd->query($sql);
    $albums = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return $albums[0]['idA'];
    }

    //convert year to date
    $date = $year . "-01-01";

    if($year == -1)
    {
        $sql = "INSERT INTO Albums(Titre) VALUES ('$titre')";
    }
    else
    {
        $sql = "INSERT INTO Albums(Titre, DateSortie) VALUES ('$titre', '$date')";
    }

    mysqli_query($bdd, $sql);
    $idA = mysqli_insert_id($bdd);
    return $idA;
}
function postGenres($genre, $bdd)
{
    $genre = $bdd->real_escape_string($genre);

    $sql = "SELECT idG FROM Genres WHERE Genre = '$genre'";
    $result = $bdd->query($sql);
    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return $genres[0]['idG'];
    }

    $sql = "INSERT INTO Genres(Genre) VALUES ('$genre')";
    mysqli_query($bdd, $sql);
    $idG = mysqli_insert_id($bdd);
    return $idG;
}
function postPossède($idC, $idV, $idA, $NuméroPiste, $bdd)
{
    $idC = $bdd->real_escape_string($idC);
    $idV = $bdd->real_escape_string($idV);
    $idA = $bdd->real_escape_string($idA);
    $NuméroPiste = $bdd->real_escape_string($NuméroPiste);

    $sql = "SELECT idC, idV, idA FROM Possède WHERE idC = '$idC' AND idV = '$idV' AND idA = '$idA'";
    $result = $bdd->query($sql);
    $possède = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return;
    }

    $sql = "INSERT INTO Possède(idC, idV, idA, NuméroPiste) VALUES ('$idC', '$idV', '$idA', '$NuméroPiste')";
    mysqli_query($bdd, $sql);
    $idC = mysqli_insert_id($bdd);
}
function postCaracterise($idC, $idG, $bdd)
{
    $idC = $bdd->real_escape_string($idC);
    $idG = $bdd->real_escape_string($idG);

    $sql = "SELECT idC, idG FROM Caractérise WHERE idC = '$idC' AND idG = '$idG'";
    $result = $bdd->query($sql);
    $caractérise = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return;
    }

    $sql = "INSERT INTO Caractérise(idC, idG) VALUES ('$idC', '$idG')";
    mysqli_query($bdd, $sql);
    $idC = mysqli_insert_id($bdd);
}
function getGroupes()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT * FROM GroupeMusique";
    $result = mysqli_query($bdd, $req_groupe);
    $groupes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $groupes;
}
function getRowData($bdd)
{
    $database = "dataset";
    $table = "songs2000";
    $bdd -> select_db($database);
    $req = "SELECT * FROM " . $table;
    $result = mysqli_query($bdd, $req);
    $rowData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $rowData;
}
function getGenres()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT * FROM Genres";
    $result = mysqli_query($bdd, $req_groupe);
    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $genres;
}
?>