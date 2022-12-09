< ! -- REJANY Alexandre p2102785
       BOUILLY Jérémy p2103485 -- >
<?php
    require('inc/routes.php');
    require('modele/modele.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Rhyve</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <?php include('static/header.php'); ?>
        <div class="main">
            <?php include('static/nav.php'); ?>
            <?php
                $controleur = 'controleurAccueil';
                $vue = 'vueAccueil';
                if (isset($_GET['action'])) {
                    if (isset($routes[$_GET['action']])) {
                        $controleur = $routes[$_GET['action']]['controleur'];
                        $vue = $routes[$_GET['action']]['vue'];
                    }
                }
                include('controleurs/'.$controleur.'.php');
                include('vues/'.$vue.'.php');
            ?>
        </div>
        <?php include('static/footer.php'); ?>
    </body>
</html>