<?php
    require_once('fonctions.php');
    is_connect();
    $msg="null";
    $check= "off";
    $checked=array();
    $_SESSION['checkbox']= "";
    $score=0;
    $j=0;

    //tableau de stockage pour les reponses donner par le joueur.
    $newTab= array(
        'reponse_donner' => array()
    );

    // Fichier JSON contenant les questions.
    $data= file_get_contents('questions.json');
    $data= json_decode($data, true);

// Fichier JSON Contenant le nombre de question par jeu.
    $data2= file_get_contents('nombre_questions.json');
    $data2= json_decode($data2, true);

// Fichier JSON Contenant les utilisateurs.
    $data3= file_get_contents('utilisateur.json');
    $data3= json_decode($data3, true);

    foreach ($data3 as $value){
        $joueur[] = $value;
    }

    foreach ($data as $value){
        $questions[] = $value;
    }

    //c'est cette index la qui va permettre de paginer!
    $page_Actuelle=1;

    if(isset($_POST['prec']) || isset($_POST['suiv'])){

        // On enregistres les valeurs repondu par l'utilisateur.

    	if(isset($_POST['suiv']))
    	{
             $page_Actuelle=$_POST['page']+1;
    	}
    	if(isset($_POST['prec']))
    	{
             $page_Actuelle=$_POST['page']-1;
    	}	
    }

// Debut pagination
    $total = $data2['nbr_questions_par_jeu'];
    define ('nbr_Par_Page', 1);
    $nbr_De_Page = ceil($total/nbr_Par_Page);
    $cpt=1;
  
        if ($page_Actuelle < 1){
            $page_Actuelle = 1;
        }
        if ($page_Actuelle > $nbr_De_Page)
        {
            $page_Actuelle = $nbr_De_Page;
        }

    $indiceD=($page_Actuelle-1)*nbr_Par_Page;
    $indiceF=$indiceD + nbr_Par_Page - 1;
?>

<div class="container_page_de_jeu">

    <div class="container-header_page_de_jeu">

            <div class="avatar_page_de_jeu">
                <img src="<?php if (isset($_SESSION['user']['photo'])){ echo $_SESSION['user']['photo'];} ?>" class="image-ronde_joueur">
                    <div class="nom_prenom_joueur">
                        <p>
                            <strong>
                                <?php
                                    echo $_SESSION['user']['prenom'];
                                ?>
                                <br>
                                <?php
                                    echo $_SESSION['user']['nom'];
                                ?>
                            </strong>
                        </p>
                    </div>
            </div>

        <div class="title_page_de_jeu">
            <strong>BIENVENUE SUR LA PLATFORME DE JEU DE QUIZZ JOUEUR ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRAL</strong>
        </div>
        <form action="" method="POST" id="form-connexion">
            
                <button type="submit" class="btn-form-page_de_jeu" name="btn_submit_page_de_jeu" id=""><a href="index.php?statut=logout">Deconnexion</a></button>
        
        </form>

    </div>

    <div class="zone-affichage_page_de_jeu_Questions">

<!-- on affiche les questions sur le header-->
        <div class="header-zone-question">
            <?php
                for ($i=$indiceD; $i<=$indiceF; $i++){
                    if (isset($questions[$i])){
            ?>
                        <div class="numero_question">
                            <?php
                            echo 'Questions ' .($i+$cpt).'/'.$data2['nbr_questions_par_jeu'];
                            ?>
                        </div>

                        <div class="questions">
                            <?php
                                echo $questions[$i]['question'];
                            ?>
                        </div>
            <?php
                    }
            ?>
        </div>
<!-- Fin Affichage -->


<!-- On affiche le nombre de point-->
        <div class="body-zone-question">
            <div class="nombre_point">
                <p>
                    <?php
                            echo $questions[$i]['nbr_point'].' pts';
                    ?>
                </p>
            </div>
<!-- Fin affichage -->


<!-- On affiche les checkbox ou les boutons radios ainsi que les reponses possible -->

            <div class="reponses_et_input">
                <form action="" method="POST" >
                           <!-- Debut affichage des buttons checkbox et leur reponse possible -->     

                    <input type="hidden" name="page" value="<?=@$page_Actuelle?>"/>
                    
                    <?php

                        $j=0;
                        while (isset($questions[$i]['reponses_possible'][$j])){
                            if ($questions[$i]['type_reponse']=="multiple"){
                                if (isset($questions[$i]['reponses_possible'][$j])){
                                    if (isset($questions[$i]['bonnes_reponses'][$j])){
                    ?>
                                    <span class="reponse_et_input_checkbox">
                                        <input type="checkbox" name="checkbox_<?= $j; ?>" <?php do {if (isset($_POST['checkbox_'.$j])){$_SESSION['checkbox']="checked"; echo $_SESSION['checkbox'];}else{$_SESSION['checkbox']=""; echo $_SESSION['checkbox'];}}while (isset($checked[$j]) && ($checked[$j]==="on"))?> class="btn btn-checkbox">
                                        <strong>
                    <?php
                                            echo $questions[$i]['reponses_possible'][$j];
                    ?>
                                        </strong>
                                    </span>
            <!-- Fin affichage des checkbox et leur reponse-->
                    <?php
                                        if(isset($_POST['prec']) || isset($_POST['suiv'])){

                                        // on stocke les valeurs repondu par l'utilisateur dans un tableau.
                                                                    
                                        if (isset($_POST['checkbox_'.$j])){
                                            array_push ($newTab['reponse_donner'], $questions[$i]['reponses_possible'][$j]);
                                            array_push ($checked, $_POST['checkbox_'.$j]);
                                        }
                                        if (!isset($_POST['checkbox_'.$j])){
                                            array_push ($newTab['reponse_donner'], $msg);
                                        } 
                                        // Puis on enregistre le tableau dans une session.
                                            $_SESSION['checked'][$j]=$checked;
                                            $_SESSION['newtab']=$newTab['reponse_donner'];

                                        }
                                    }
                                }
                            }
                    ?>
                                <br>
                                <br>
            <!-- Debut affichage des buttons radio et leur reponse possible -->     
                    <?php
                                                            
                            if ($questions[$i]['type_reponse']=="simple"){
                                if (isset($questions[$i]['reponses_possible'][$j])){
                                    if (isset($questions[$i]['bonnes_reponses'][$j])){
                    ?>
                                    <span class="reponse_et_input_radio">
                                        <input type="radio" name="radio" <?php do {if (isset($_POST['radio'])){$_SESSION['radio']="checked"; echo $_SESSION['radio'];}else{$_SESSION['radio']=""; echo $_SESSION['radio'];}}while (isset($checked[$j]) && ($checked[$j]==="on"))?> class="btn btn-radio">
                                        <strong>
                        <?php
                                            echo $questions[$i]['reponses_possible'][$j];
                        ?>
                                        </strong>
                                    </span>
                    <?php
                                if(isset($_POST['prec']) || isset($_POST['suiv'])){

                                    // on stocke les valeurs repondu par l'utilisateur dans un tableau.
                                                                
                                    if (isset($_POST['radio'])){
                                        if (!empty($_POST['radio'])){
                                            array_push ($newTab['reponse_donner'], $questions[$i]['reponses_possible'][$j]);
                                            array_push ($checked, $_POST['radio']);
                                        }
                                    }
                                    if (!isset($_POST['radio'])){
                                        array_push ($newTab['reponse_donner'], $msg);
                                    } 
                                    // Puis on enregistre le tableau dans une session.
                                        $_SESSION['radio']=$checked;
                                        $_SESSION['newtab']=$newTab['reponse_donner'];

                                    
                                    }
                                }
                            }
                        }
                    ?>
            <!-- Fin affichage des radio et leur reponse possible-->

            <!-- Affichage champ de reponse -->

                    <?php                                                        
                            if  ($questions[$i]['type_reponse']=="text"){
                    ?>
                                <input type="text" name="Reponse_text_<?= $j; ?>" error="error" placeholder="Veuillez votre reponse ici..." class="champ_de_reponse_text">
                    <?php
                            }
                            $j++;
                        }
                    }

                    //  On verifie si les reponses sont valide et on donne le point.
                    if (isset($_POST['terminer']) || isset($_POST['suiv']) || isset($_POST['prec'])){
                        for ($i=0; $i<$j; $i++){
                            if ($questions[$i]['bonnes_reponses']==$_SESSION['newtab']){
                                $score = $questions[$i]['nbr_point'];
                                $_SESSION['score'] += $score;
                            }
                        }
                    }

                    ?>
            <!-- Fin affichage du champ de texte pour reponse type text -->
<!-- Fin Pagination -->
<!-- Affichage et Activation des Boutton Suivant, Precedent et Terminer -->
            </div>

            <div class="footer-zone-question">
            <?php
                if ($page_Actuelle>1){
            ?>
                    <input type="submit" name="prec"  value="Précédent" class="button-precedent-questions-question">
            <?php
                }

                for ($i=1; $i<=$nbr_De_Page; $i++){
                    
                }

                if ($i >= $page_Actuelle && $page_Actuelle!=$nbr_De_Page){            
            ?>
                    <input type="submit" name="suiv" value="Suivant" class="button-suivant-questions-question">
            <?php
                }else
                    if ($i > $page_Actuelle && $page_Actuelle==$nbr_De_Page){            
                ?>
                    <input type="submit" name="terminer" value="Terminer" class="button-terminer-questions-question">
            <?php
                    }
            ?>

            </div>
        </form>
        </div>


<!-- FIN Affichage et Activation des Boutton Suivant, Precedent et Terminer -->
    </div>


<!-- Partie des SCORES -->

    <div class="zone-affichage_page_de_jeu_Scores">

        <div class="option_score">

            <div class="top_scores">
                <ul>
                    <li class="menu-top_scores">
                            <a href="index.php?lien=jeu&page=top_scores">Top Scores</a>
                    </li>
                </ul>
            </div>
            <div class="mon_meilleur_score">
                <ul>
                    <li class="menu-mon_meilleur_score">
                            <a href="index.php?lien=jeu&page=mon_meilleur_score">Mon Meilleur Score</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="affichage_score">
            <?php
                if (isset($_GET['page'])){
                    switch($_GET['page']){
                        case "top_scores":
                            include("top_scores.php");
                        break;
                        case "mon_meilleur_score":
                            require_once("mon_meilleur_score.php");
                        break;
                        default;
                    }
                }
            ?>
        </div>

    </div>

</div>























<style>

/* HEADER PAGE DE JEU */ /* HEADER PAGE DE JEU */ /* HEADER PAGE DE JEU */ /* HEADER PAGE DE JEU */ /* HEADER PAGE DE JEU */

.container_page_de_jeu {
    position: relative;
    top: 2%;
    left: 3%;
    height: 96%;
    width: 94%;
    background-color: rgb(231, 223, 223);
}

.container-header_page_de_jeu {
    height: 100px;
    background-color: #51bfd0;
}

.avatar_page_de_jeu {
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 5px;
    text-align: center;
    width: 5%;
    height: 100%;
}

.image-ronde_joueur {
    float: left; 
    width : 65px; 
    height : 65px; 
    margin-left: 1%; 
    margin-top: 0%; 
    border: none; 
    -moz-border-radius : 75px; 
    -webkit-border-radius : 75px; 
    border-radius : 75px;
}

.nom_prenom_joueur p{
    float: left; 
    margin-top: 2%; 
    left: 15%; 
    position: relative;
    color: white;
}

.title_page_de_jeu {
    float: left;
    width: 75%;
    position: relative;
    top: -100%;
    left: 5%;
    color: white;
    font-size: 30px;
    font-weight: bold;
    padding: 0px;
    text-align: center;
}

.btn-form-page_de_jeu {
    float: right;
    right: 2%;
    top: 5%;
    padding: 10px;
    color: white;
    background-color: #3addd6;
    font-size: 12px;
    font-weight: bold;
    border-radius: 5px;
    border: 1px solid darkturquoise;
    text-decoration: none;
    position: absolute;
    width: 10%;
    
}

.btn-form_page_de_jeu a {
    text-decoration: none;
    color: white;
}

.form-control_page_de_jeu {
    width: 100%;
    height: 30px;
    border-radius: 5px;
    border: 1px solid silver;
    font-size: 12px;
    font-weight: bold;
    color: silver;
}

/* ZONE AFFICHAGE PAGE DE JEU */ /* ZONE AFFICHAGE PAGE DE JEU */ /* ZONE AFFICHAGE PAGE DE JEU */ /* ZONE AFFICHAGE PAGE DE JEU */

.zone-affichage_page_de_jeu_Questions {
    float: left;
    width: 65%;
    height: 75%;
    top: 20%;
    left: 2%;
    border: 2px solid darkturquoise;
    border-radius: 5px 5px 5px 5px;
    background-color: white;
    position: absolute;
    overflow: auto;
}

.zone-affichage_page_de_jeu_Scores {
    float: right;
    width: 28%;
    height: 65%;
    top: 25%;
    right: 2%;
    border-radius: 5px 5px 5px 5px;
    background-color: white;
    position: absolute;
}

.header-zone-question {
    float: left;
    width: 97%;
    height: 30%;
    left: 1.5%;
    top: 2%;
    bottom: 1%;
    position: relative;
    background: #e7e4e4;
}

.numero_question {
    text-align: center;
    font-weight: bold;
    font-size: 33px;
}

.questions {
    top: 25%;
    position: relative;
    text-align: center;
    font-size: 25px;
}

.body-zone-question {
    width: 97%;
    height: 60%;
    top: 5%;
    left: 1.5%;
    position: relative;
    overflow: auto;
}

.nombre_point {
    height: 13%;
}

.nombre_point p {
    position: absolute;
    box-shadow:0 0 5px #000;
    top: -9%;
    left: 90%;
    font-size: 21px;
    background-color: #e7e4e4;
}

.reponses_et_input {
    height: 50%;
    position: relative;
    top: 0%;
    padding: 0% 0px 5% 0px;
}

.reponse_et_input_checkbox {
    position: relative;
    float: left;
    left: 35%;
    top: 20%;
    font-size: 20px;
}

.reponse_et_input_radio {
    position: relative;
    float: left;
    left: 35%;
    top: 20%;
    font-size: 20px;
}

.champ_de_reponse_text {
    position: relative;
    float: left;
    width: 50%;
    height: 20%;
    left: 25%;
    top: 50%;
    text-align: center;
    border-radius: 4px 4px 4px 4px;
    font-size: 20px;
    font-weight: bold;
}

.footer-zone-question {
    width: 97%;
    height: 15%;
    top: 5%;
    left: 1.5%;
    position: relative;
}

.button-suivant-questions-question {
    float: right;
    width: 20%;
    height: 60%;
    top: 20%;
    right: 5%;
    background-color: darkturquoise;
    color: white;
    border-radius: 5px 5px;
    position: relative;
}

.button-precedent-questions-question {
    float: left;
    width: 20%;
    height: 60%;
    top: 25%;
    left: 5%;
    background-color: darkturquoise;
    color: white;
    border-radius: 5px 5px;
    position: relative;
}

.button-terminer-questions-question {
    float: right;
    width: 20%;
    height: 60%;
    top: 25%;
    right: 5%;
    background-color: darkturquoise;
    color: white;
    border-radius: 5px 5px;
    position: relative;
}

.affichage_score {
    float: right;
    width: 95%;
    height: 80%;
    top: 15%;
    right: 2%;
    border-radius: 5px 5px 5px 5px;
    position: absolute;
}

</style>

