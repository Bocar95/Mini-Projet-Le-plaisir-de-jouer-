
    <div class="nom_prenom_mon_meilleur_score_joueur">
    <p>
        <strong>
        <span class="nom_prenom_joueur">
            <?php
                echo $_SESSION['user']['prenom'];
            ?>
            &nbsp;
            <?php
                echo $_SESSION['user']['nom'];
            ?>
            </span>

        <span class="score_joueur">
            <?php
                echo $_SESSION['user']['score'].' pts';
            ?>
        </span>
        </strong>
    </p>
</div>

<style>

.nom_prenom_mon_meilleur_score_joueur {
    float: left;
    width: 100%;
}

.score_joueur {
    float: right;

}


</style>