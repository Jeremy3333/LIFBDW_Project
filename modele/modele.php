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
    if (mysqli_error($bdd)) {
        echo mysqli_error($bdd) . "<br>";
    }
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
}
function postComporte($idC, $idV, $Libellé, $Valeur, $bdd)
{
    $idC = $bdd->real_escape_string($idC);
    $idV = $bdd->real_escape_string($idV);
    $Valeur = $bdd->real_escape_string($Valeur);

    $sql = "SELECT idC, idV, Libellé FROM Comporte WHERE idC = '$idC' AND idV = '$idV' AND Libellé = '$Libellé'";
    $result = $bdd->query($sql);
    $comporte = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        return;
    }

    $sql = "INSERT INTO Comporte(idC, idV, Libellé, Valeur) VALUES ('$idC', '$idV', '$Libellé', '$Valeur')";
    mysqli_query($bdd, $sql);
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
function getChansons()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_chanson = "SELECT * FROM Chansons";
    $result = mysqli_query($bdd, $req_chanson);
    $chansons = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $chansons;
}
function getChansonsNotFromList($idLL)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_chanson = "SELECT * FROM Chansons WHERE idC NOT IN (SELECT idC FROM Inclut WHERE idLL = '$idLL')";
    $result = mysqli_query($bdd, $req_chanson);
    $chansons = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $chansons;
}
function getVersion($idC, $idV)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_version = "SELECT Titre, Nom, Durée, Fichier FROM (VersionsMusique NATURAL JOIN Chansons) NATURAL JOIN GroupeMusique WHERE idC = '$idC' AND idV = '$idV'";
    $result = mysqli_query($bdd, $req_version);
    $version = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $version;
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
function getTopChansons()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT ch.Titre, c.Valeur FROM Chansons ch NATURAL JOIN Comporte c WHERE c.Libellé = 'playcount' ORDER BY c.Valeur DESC LIMIT 20";
    $result = mysqli_query($bdd, $req_groupe);
    $topChansons = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $topChansons;
}
function getChansonsRecente()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT Titre, DateCréation FROM Chansons ORDER BY DateCréation DESC LIMIT 5";
    $result = mysqli_query($bdd, $req_groupe);
    $chansonsRecente = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $chansonsRecente;
}
function getChansonsPassée()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT ch.Titre, c.Valeur FROM Chansons ch NATURAL JOIN Comporte c WHERE c.Libellé = 'skipcount' ORDER BY c.Valeur DESC LIMIT 5";
    $result = mysqli_query($bdd, $req_groupe);
    $topChansons = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $topChansons;
}
function getListesDeLecture()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);
    $req_groupe = "SELECT * FROM Listes_de_lecture";
    $result = mysqli_query($bdd, $req_groupe);
    $listesDeLecture = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //close connection
    mysqli_close($bdd);
    return $listesDeLecture;
}
function nomGenre($genre)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT Genre FROM Genres WHERE idG = '$genre'";
    $result = mysqli_query($bdd, $req_groupe);

    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $genres[0]['Genre'];
}
function pourcentageGenre($idLL,$genre)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT * FROM (Inclut NATURAL JOIN VersionsMusique) NATURAL JOIN Caractérise WHERE idG='$genre' AND idLL='$idLL'";
    $result = mysqli_query($bdd, $req_groupe);

    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    $versions = getVersionLL($idLL);

    $pourcent = (count($genres)/count($versions))*100;

    return $pourcent;
}
function postListesdeLecture($titre)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $titre = $bdd->real_escape_string($titre);

    $sql = "INSERT INTO Listes_de_lecture(Titre,DateCréation) VALUES ('$titre',CAST(NOW() AS DATE))";
    mysqli_query($bdd, $sql);

    $idLL = mysqli_insert_id($bdd);

    mysqli_close($bdd);

    return $idLL;
}
function getVersionByGenre($genre)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT v.* FROM VersionsMusique v NATURAL JOIN Caractérise t WHERE t.idG = '$genre'";
    $result = mysqli_query($bdd, $req_groupe);

    $versions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $versions;
}
function getVersionByGenreAndPref($genre,$pref,$nbe)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT v.* FROM (VersionsMusique v NATURAL JOIN Caractérise t) NATURAL JOIN Comporte c WHERE t.idG = '$genre' AND c.Libellé = '$pref' ORDER BY c.Valeur DESC LIMIT ".$nbe;
    $result = mysqli_query($bdd, $req_groupe);

    $versions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $versions;
}
function postInclut($idLL,$idV,$idC)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $sql = "SELECT idC FROM VersionsMusique WHERE idC = '$idC' AND idV = '$idV'";
    $result = $bdd->query($sql);
    $row = $result->fetch_assoc();
    $idC = $row['idC'];

    $sql = "INSERT INTO Inclut VALUES ('$idC','$idV','$idLL')";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
function getVersionAll()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT * FROM VersionsMusique";
    $result = mysqli_query($bdd, $req_groupe);

    $versions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $versions;
}
function getVersionAllByPref($pref,$nbe)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT v.* FROM VersionsMusique v NATURAL JOIN Comporte c WHERE c.Libellé = '$pref' ORDER BY c.Valeur DESC LIMIT ".$nbe;
    $result = mysqli_query($bdd, $req_groupe);

    $versions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $versions;
}
function getVersionLL($idLL)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT v.* FROM VersionsMusique v NATURAL JOIN Inclut i WHERE i.idLL = '$idLL'";
    $result = mysqli_query($bdd, $req_groupe);

    $versionsLL = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($bdd);

    return $versionsLL;
}
function getPlaylistRecente()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT * FROM Listes_de_lecture ORDER BY DateCréation DESC LIMIT 5";
    $result = mysqli_query($bdd, $req_groupe);

    $listesDeLecture = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($bdd);

    return $listesDeLecture;
}
function getPlaylistAncienne()
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT * FROM Listes_de_lecture ORDER BY DateCréation ASC LIMIT 5";
    $result = mysqli_query($bdd, $req_groupe);

    $listesDeLecture = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($bdd);

    return $listesDeLecture;
}
function deleteInclut($idC,$idLL)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $sql = "DELETE FROM Inclut WHERE idC = '$idC' AND idLL = '$idLL'";
    mysqli_query($bdd, $sql);

    mysqli_close($bdd);
}
function getInfo($idLL)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT * FROM Listes_de_lecture WHERE idLL = '$idLL'";
    $result = mysqli_query($bdd, $req_groupe);

    $ldl = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $ldl;
}
function getTitreChanson($idC)
{
    $username = "p2103485";
    $bdd = getBdd();
    $bdd -> select_db($username);

    $req_groupe = "SELECT Titre FROM Chansons WHERE idC = '$idC'";
    $result = mysqli_query($bdd, $req_groupe);

    $titre = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($bdd);

    return $titre[0]['Titre'];
}
function timeToSeconds(string $time)
{
    $arr = explode(':', $time);
    if (count($arr) === 3) {
        return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
    }
    return $arr[0] * 60 + $arr[1];
}
?>