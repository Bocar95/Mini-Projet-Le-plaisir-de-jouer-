<?php
session_start();

$j=0;
$i=0;
while (isset($questions[$i]['reponses_possible'][$j])){
    if ($questions[$i]['type_reponse']=="multiple"){
        if (isset($questions[$i]['reponses_possible'][$j])){
            if (isset($questions[$i]['bonnes_reponses'][$j])){

                if(isset($_POST['prec']) || isset($_POST['suiv'])){

                // on stocke les valeurs repondu par l'utilisateur dans un tableau.
                                            
                if (isset($_POST['checkbox_'.$j])){
                    $checked= $_SESSION['checked'];
                    array_push ($newTab['reponse_donner'], $questions[$i]['reponses_possible'][$j]);
                }
                if (!isset($_POST['checkbox_'.$j])){
                    array_push ($newTab['reponse_donner'], $msg);
                } 
                // Puis on enregistre le tableau dans une session.
                    $_SESSION['newtab']=$newTab['reponse_donner'];

                //  On verifie si les reponses sont valide et on donne le point.
                    if ($questions[$i]['bonnes_reponses']==$_SESSION['newtab']){
                        $score = $questions[$i]['nbr_point'];
                        $_SESSION['score'] = $_SESSION['score']+$score;
                    }
                }
            }
        }
    }

                                    
    if ($questions[$i]['type_reponse']=="simple"){
        if (isset($questions[$i]['reponses_possible'][$j])){
            if (isset($questions[$i]['bonnes_reponses'][$j])){

                if(isset($_POST['prec']) || isset($_POST['suiv'])){

                // on stocke les valeurs repondu par l'utilisateur dans un tableau.
                                            
                if (isset($_POST['radio_'.$j])){
                    if (!empty($_POST['radio_'.$j])){
                        array_push ($newTab['reponse_donner'], $questions[$i]['reponses_possible'][$j]);
                    }
                }
                if (!isset($_POST['radio_'.$j])){
                    array_push ($newTab['reponse_donner'], $msg);
                } 
                // Puis on enregistre le tableau dans une session.

                    $_SESSION['newtab']=$newTab['reponse_donner'];

                //  On verifie si les reponses sont valide et on donne le point.
                    if ($questions[$i]['bonnes_reponses']==$_SESSION['newtab']){
                        $score = $questions[$i]['nbr_point'];
                        $_SESSION['score'] = $_SESSION['score']+$score;
                    }
                }
            }
        }
    }
    $j++;
    $i++;
}


?>