<?php
if(isset($_GET['AddList']))
{
    postInclut($_GET['idLL'], 1, $_GET['AddList']);
    // header('Location: index.php?action=Liste&idLL='.$_GET['idLL']);
}
?>