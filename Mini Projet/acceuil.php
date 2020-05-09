<?php
is_connect();
?>

<div class="container_acceuil">

    <div class="container-header_acceuil">

        <div class="title_acceuil">
            <strong>CRÉER ET PARAMÉTRER VOS QUIZZ</strong>
        </div>
        <form action="" method="POST" id="form-connexion">
            <div class="input-form_acceuil">
                <button type="submit" class="btn-form-acceuil" name="btn_submit_acceuil" id=""><a href="index.php?statut=logout">Deconnexion</a></button>
            </div>
        </form>

    </div>

    <div class="container_menu">

        <div class="container-header_menu">

            <div class="title_menu">
                <img src="<?= $_SESSION['user']['photo'] ?>" class="image-ronde">
                    <div class="nom_prenom">
                        <p>
                            <strong>
                                <?php
                                    echo $_SESSION['user']['prenom'];
                                ?>
                                <br>&nbsp;&nbsp;&nbsp;
                                <?php
                                    echo $_SESSION['user']['nom'];
                                ?>
                            </strong>
                        </p>
                    </div>
            </div>

        </div>

        <div class="option">
            <div class="liste-questions">
                <ul>
                    <li class="menu-liste-questions">
                       
                            <a href="index.php?lien=acceuil&page=questions&fenetre=1">Liste Questions</a>
                            <img src="images/ic-liste.png" class="icone-1">
                        
                    </li>
                </ul>
            </div>
            <div class="créer-admin">
                <ul>
                    <li class="menu-créer-admin">
                    
                            <a href="index.php?lien=acceuil&page=creer_admin">Créer Admin</a>
                            <img src="images/ic-ajout-active.png" class="icone-2">
                    </li>
                </ul>
            </div>
            <div class="liste-joueur">
                <ul>
                    <li class="menu-liste-joueur">
                    
                        <a href="index.php?lien=acceuil&page=liste_joueur&fenetre=1">Liste Joueur</a>
                        <img src="images/ic-liste.png" class="icone-3">
                    
                    </li>
                </ul>
            </div>
            <div class="créer-questions">
                <ul>
                    <li class="menu-créer-questions">
                        
                            <a href="index.php?lien=acceuil&page=creer_questions">Créer Questions</a>
                            <img src="images/ic-ajout.png" class="icone-4">
                        
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <div class="zone-affichage">
        <?php
            if (isset($_GET['page'])){
                switch($_GET['page']){
                        case "questions":
                            require_once("questions.php");
                        break;
                        case "creer_admin":
                            require_once("inscription.php");
                        break;
                        case "liste_joueur":
                            require_once("joueur.php");
                        break;
                        case "creer_questions":
                            require_once("creer_question.php");
                        break;
                        default;
                    }
            }
        ?>
    </div>


