<div class="Statistique">
    <div class="Stat-left">
        <div class="Stat-left-top">
            <div class="box">
                <div class="box-header">
                    <p>musiques les plus récentes</p>
                </div>
                <ul>
                    <?php
                    foreach($ChansonsRecente as $chanson)
                    {
                        echo "<li><p>".$chanson['Titre']."</p> <p>".$chanson['DateCréation']."</p></li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="box">
                <div class="box-header">
                    <p>musiques les plus passée</p>
                </div>
                <ul>
                    <?php
                    foreach($ChansonsPassée as $chanson)
                    {
                        echo "<li><p>".$chanson['Titre']."</p> <p>".$chanson['Valeur']."</p></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="Stat-left-bottom">
            <div class="box-wide">
                <div class="box-header"><p>playlist par date de création</p></div>
                <div class="box-content">
                    <div class="half">
                        <ul>
                            <?php
                            foreach($PlaylistRecente as $playlist)
                            {
                                echo "<li><p>".$playlist['Titre']."</p> <p>".$playlist['DateCréation']."</p></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="half">
                        <ul>
                            <?php
                            foreach($PlaylistAncienne as $playlist)
                            {
                                echo "<li><p>".$playlist['Titre']."</p> <p>".$playlist['DateCréation']."</p></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
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