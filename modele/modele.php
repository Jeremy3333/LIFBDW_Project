<?php
//include('inc/includes.php');
function getBdd()
{
    $servername = "localhost";
    $username = "p2102785";
    $password = "Supper10Jurist";
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
function addVersionsMusique($titre, $date, $durée, $nomFichier, $groupe, $genre)
{
    $username = "p2102785";
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
function postVersionsMusique($titre, $durée, $nomFichier, $groupe)
{
    $username = "p2102785";
    $bdd = getBdd();
    if(!(isset($titre) && is_string($titre) && isset($durée) && is_string($durée) && isset($nomFichier) && is_string($nomFichier) && isset($groupe) && is_string($groupe)))
    {
        return false;
    }
    $titre = $bdd->real_escape_string($titre);
    $durée = $bdd->real_escape_string($durée);
    $nomFichier = $bdd->real_escape_string($nomFichier);
    $groupe = $bdd->real_escape_string($groupe);
    $bdd -> select_db($username);

    $sql = "SELECT idGM FROM GroupeMusique WHERE Nom = '$groupe'";
    $result = $bdd->query($sql);
    //check error and print it
    if (mysqli_errno($bdd)) {
        $error = mysqli_error($bdd);
        echo $error;
    }
    $row = $result->fetch_assoc();
    $groupe = $row['idGM'];

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
        $sql = "SELECT MAX(idC) FROM Chansons";
        $result = $bdd->query($sql);
        $row = $result->fetch_assoc();
        $idC = $row['MAX(idC)'] + 1;
        // add the song in the Chansons table
        $sql = "INSERT INTO Chansons(idGM, idC, Titre) VALUES ('$idGM', '$idC', '$titre')";
        mysqli_query($bdd, $sql);
    }
    // check what's the last id of the VersionsMusique table

    if($titre != '')
    {
        $sql = "SELECT MAX(idV) FROM VersionsMusique";
        $result = $bdd->query($sql);
        $row = $result->fetch_assoc();
        $idV = $row['MAX(idV)'] + 1;
        $req_mus = "INSERT INTO VersionsMusique VALUES('$idC', '$idV', '$titre', '$durée', '$nomFichier')";
        mysqli_query($bdd, $req_mus);
    }
    // if the idGM isn't equal to groupe , it means that the versions is a reprise, so we add it
    if($idGM != $groupe)
    {
        $req_mus = "INSERT INTO Repris VALUES('$groupe', '$idGM', '$idC', '$idV')";
        mysqli_query($bdd, $req_mus);
    }
    //close connection
    mysqli_close($bdd);
}
function postGroupe($nom)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $nom = $bdd->real_escape_string($nom);

    $sql = "SELECT * FROM GroupeMusique WHERE Nom = '$nom'";
    $result = $bdd->query($sql);
    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    $sql = "INSERT INTO GroupeMusique(Nom) VALUES ('$nom')";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
function postGenre($genre)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $genre = $bdd->real_escape_string($genre);

    $sql = "SELECT * FROM Genres WHERE Genre = '$genre'";
    $result = $bdd->query($sql);
    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    // check the last idG in the Genres table
    $sql = "SELECT MAX(idG) FROM Genres";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idG = $row['MAX(idG)'] + 1;

    $sql = "INSERT INTO Genres(idG, Genre) VALUES ('$idG', '$genre')";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
function postCaracterise($titre, $genre)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $titre = $bdd->real_escape_string($titre);
    $genre = $bdd->real_escape_string($genre);

    $sql = "SELECT idC FROM Chansons WHERE Titre = '$titre'";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idC = $row['idC'];

    $sql = "SELECT idG FROM Genres WHERE Genre = '$genre'";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idG = $row['idG'];

    $sql = "INSERT INTO Caractérise VALUES ('$idC', '$idG')";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
function getGroupes()
{
    $username = "p2102785";
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
function getRowData()
{
    $database = "dataset";
    $table = "songs100";
    $bdd = getBdd();
    $bdd -> select_db($database);
    $req = "SELECT * FROM " . $table;
    $result = mysqli_query($bdd, $req);
    $rowData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($bdd);
    return $rowData;
}
function getGenres()
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT * FROM Genres";
    $result = mysqli_query($bdd, $req_groupe);
    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $genres;
}
function getVersion($genre)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT v.* FROM (VersionsMusique v NATURAL JOIN Caractérise t) NATURAL JOIN Genres g WHERE g.idG = '$genre'";
    $result = mysqli_query($bdd, $req_groupe);
    $versions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $versions;
}
function postListesdeLecture($titre)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $titre = $bdd->real_escape_string($titre);

    $sql = "SELECT * FROM Listes_de_lecture WHERE Titre = '$titre'";
    $result = $bdd->query($sql);
    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    $sql = "INSERT INTO Listes_de_lecture(Titre,DateCréation) VALUES ('$titre',CAST(NOW() AS DATE))";
    mysqli_query($bdd, $sql);

    $idLL = mysqli_insert_id($bdd);

    mysqli_close($bdd);

    return $idLL;
}
function postInclut($idLL,$idV)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $sql = "SELECT idC FROM VersionsMusique WHERE idV = '$idV'";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idC = $row['idC'];

    $sql = "INSERT INTO Inclut VALUES ('$idC','$idV','$idLL')";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
function deleteInclut($idLL)
{
    $username = "p2102785";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $sql = "DELETE * FROM Inclut WHERE idLL = '$idLL'";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
?>