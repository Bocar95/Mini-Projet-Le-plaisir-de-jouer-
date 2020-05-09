
    <?php
        $js= file_get_contents('utilisateur.json');

        $js= json_decode($js, true);

        foreach ($js as $value){
            if ($value["profil"]=="joueur"){
                $joueur[] = $value;
            }
        }

        $score=[];

        foreach ($joueur as $key => $value){
            array_push($score, $value['score']);
        }

        array_multisort($score, SORT_DESC, $joueur);

        foreach ($joueur as $key => $value){
            if ($key < 5){
                ?>
                <div class="nom_prenom_top_score_joueur">
                    <span class="nom_prenom_joueur">
        <?php
                        echo $value['prenom'];
        ?>
                        &nbsp;
        <?php
                        echo $value['nom'];
        ?>
                    </span>
    
                    <span class="score_joueur">
        <?php
                        echo $value['score'].' pts';
        ?>
                    </span>
        <?php
                }
        ?>
                </div>
        <?php
            }
    
        ?>
<style>

.nom_prenom_top_score_joueur {
    float: left;
    width: 100%;
}

.score_joueur {
    float: right;
}


</style>
