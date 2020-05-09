<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quizz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="header">
        <div class="logo"></div>
        <div class="header-text">Le plaisir de jouer</div>
    </div>

    <div class="content">
        
    <?php
    session_start();

            require_once('fonctions.php');

            if (isset($_GET['lien'])){
                switch($_GET['lien']){
                    case "acceuil":
                        require_once("acceuil.php");
                    break;
                    case "jeu":
                        require_once("page_de_jeu.php");
                    break;
                    case "inscription":
                        require_once("inscription.php");
                    break;
                    default;
                }
            }else {
                if (isset($_GET['statut']) && $_GET['statut']==="logout"){
                    deconnexion();
                }
                require_once('connexion.php');
            }

    ?>
    </div>

</body>
</html>