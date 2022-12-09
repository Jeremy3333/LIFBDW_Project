<?php
function makeRandomPlaylist($titre, $duree, $genre, $pref)
{
    $addduree = 0;
    $i = 1;  //compteur pour gérer le genre majoritaire de la playlist
    $idLL = postListesdeLecture($titre);
    $timepl = timeToSeconds($duree);

    //boucle principalle
    while ($timepl-60 >= $addduree or $timepl+60 <= $addduree)
    {
        //vérifie le retour du form pour savoir si l'utilisateur n'a pas demandé un genre spécifique 
        if ($genre=='default')  
            $i=4; //si oui passer uniquement par la fonction de récupérations de version sans genre affilié
        
        if($pref=='default') //vérifie le retour du form pour savoir si l'utilisateur n'a pas une préférence
        {
            //si oui passer uniquement par les fonction de récupérations de version sans préférence
            if($i==4)
            {
                $versions = getVersionAll();
                $i=1;
            }
            else
            {
                $versions = getVersionByGenre($genre);
                $i++;
            }
        }
        else
        {
            //si non passer uniquement par les fonction de récupérations de version avec préférence
            //pour le round($timepl/200), c'est une mainère d'avoir un tableau plus pertinent en ne prenant qu'un bout des versions qui corresponde à la préférence souhaitée
            //en moyenne une musique dure 4 min ce qui fait 240 secondes pour prendre plus large, j'ai mis 200 qui divise la durée souhaité pour n'avoir que le plus pertinent 
            if($i==4)
            {
                $versions = getVersionAllByPref($pref,round($timepl/200));
                $i=1;
            }
            else
            {
                $versions = getVersionByGenreAndPref($genre,$pref,round($timepl/200));
                $i++;
            }
        }

        //choix aléatoire parmis le tableau de versions retouné par l'une des fonctions précédentes
        $nbVersion = count($versions);
        $nb = rand(0,$nbVersion-1);
        postInclut($idLL,$versions[$nb]['idV'],$versions[$nb]['idC']);
        $addduree += timeToSeconds($versions[$nb]['Durée']);

        //si la durée de la playlist va trop loin, ça supprime une des musiques de la playlist de  façon aléatoire
        //le temps affichés n'est pa le bon, il y a une erreur à ce niveau dans le code
        if($timepl+60 < $addduree)
        {
            $versionsLL = getVersionLL($idLL);
            $nbVersion = count($versionsLL);
            $nbs = rand(0,$nbVersion-1);
            deleteInclut($versionsLL[$nbs]['idC'],$idLL);
            $addduree = $addduree - timeToSeconds($versionsLL[$nbs]['Durée']);
        }
    }


    //c'est pour faire un retour propre de manière css des informations souhaités après avoir créé une playlist
    $info = array(
        'duree' => $addduree,
        'idLL' => $idLL,
        'genre' => $genre,
    );

    return $info;
}


if(isset($_POST['Créer']))
{
    $titre = $_POST['titre'];
    $duree = $_POST['duree'];
    $genre = $_POST['genre'];
    $pref = $_POST['preference'];
    $info = makeRandomPlaylist($titre, $duree, $genre, $pref);
}

$Genres = getGenres();
?>