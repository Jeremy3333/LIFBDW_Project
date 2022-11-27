<div class="Statistique">
    <div class="Stat-left">
        <div class="Stat-left-top">
            <div class="box">
                <div class="box-header"></div>
            </div>
            <div class="box">
                <div class="box-header"></div>
            </div>
        </div>
        <div class="Stat-left-bottom">
            <div class="box-wide">
                <div class="box-header"></div>
            </div>
        </div>
    </div>
    <div class="Stat-right">
        <div class="box-high">
            <div class="box-header-high">
                <p>musiques avec le plus d'écoute</p>
            </div>
            <ul>
            <?php
            foreach($topChansons as $chanson)
            {
                echo '<li><p>'.$chanson['Titre'].'</p> <p>'.$chanson['Valeur'].'</p></li>';
            }
            ?>
            </ul>
        </div>
    </div>
</div>