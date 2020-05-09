<?php
    require_once('fonctions.php');
    $msg_erreur="";

    if (empty($_POST['prenom'])){
        $msg_erreur= "Veullez saisir votre prenom svp.";
    }else
        if (is_Prenom_valide($_POST['prenom'])){
            $prenom= $_POST['prenom'];

            if (empty($_POST['nom'])){
                $msg_erreur= "Veullez saisir votre nom svp.";
            }else
                if (is_nom_valide($_POST['nom'])){
                    $nom= $_POST['nom'];

                    if (empty($_POST['login'])){

                        $msg_erreur= "Veullez saisir votre login svp.";

                    }else{

                        $js= file_get_contents('utilisateur.json');

                        $js= json_decode($js, true);

                        foreach ($js as $v) {
                            if ($v['login']==$_POST['login']){
                                $msg_erreur="Ce login exist deja.";
                            }
                         }
                    }
                    
                        if (empty($_POST['password']) || preg_match("/[\s+]/", $_POST['password'])){
                                $msg_erreur= "Veullez saisir un mot de passe ne contenant pas de caractéres vide.";
                        }else
                            if (isset($_POST['confirm']) && isset($_POST['password'])){
                                if ($_POST['confirm'] != $_POST['password']){
                                $msg_erreur= "Veullez saisir des mots de passe identique.";
                                }else
                                if (isset($_POST['creer_compte']) && ($msg_erreur!="Ce login exist deja.") && isset($_SESSION['statut'])){

                                // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                                    if (isset($_FILES['monfichier']) && $_FILES['monfichier']['error'] == 0)
                                    {
                                            // Testons si le fichier n'est pas trop gros
                                            if ($_FILES['monfichier']['size'] <= 1000000)
                                            {
                                                    // Testons si l'extension est autorisée
                                                    $infosfichier = pathinfo($_FILES['monfichier']['name']);
                                                    $extension_upload = $infosfichier['extension'];
                                                    $extensions_autorisees = array('jpg', 'jpeg', 'png');
                                                    $image='photos/' . basename($_FILES['monfichier']['name']);
                                                    if (in_array($extension_upload, $extensions_autorisees))
                                                    {
                                                            // On peut valider le fichier et le stocker définitivement
                                                            move_uploaded_file($_FILES['monfichier']['tmp_name'], $image);
                                                            chmod ($image, 0755);
                                                            echo "L'envoi a bien été effectué !";
                                                    }else{
                                                        echo "L'envoi a echoué.";
                                                    }
                                            }
                                    }
                                    $creer_compte_admin=array();

                                    $creer_compte_admin['prenom']=$_POST['prenom'];
                                    $creer_compte_admin['nom']=$_POST['nom'];
                                    $creer_compte_admin['login']= $_POST['login'];
                                    $creer_compte_admin['password']= $_POST['password'];
                                    $creer_compte_admin['profil']="admin";
                                    $creer_compte_admin['photo']= $_FILES['monfichier']['name'];

                                    $js= file_get_contents('utilisateur.json');

                                    $js= json_decode($js, true);
                                    
                                    $js[]= $creer_compte_admin;

                                    $js= json_encode($js);

                                    file_put_contents('utilisateur.json', $js);

                                    header ('Location:index.php?lien=acceuil');
                                }else
                                    if ((isset($_POST['creer_compte'])) && ($msg_erreur!="Ce login exist deja.") && !isset($_SESSION['statut'])){
                                        
                                        // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                                        if (isset($_FILES['monfichier']) && $_FILES['monfichier']['error'] == 0)
                                        {
                                                // Testons si le fichier n'est pas trop gros
                                                if ($_FILES['monfichier']['size'] <= 1000000)
                                                {
                                                        // Testons si l'extension est autorisée
                                                        $infosfichier = pathinfo($_FILES['monfichier']['name']);
                                                        $extension_upload = $infosfichier['extension'];
                                                        $extensions_autorisees = array('jpg', 'jpeg', 'png');
                                                        $image='photos/' . basename($_FILES['monfichier']['name']);
                                                        if (in_array($extension_upload, $extensions_autorisees))
                                                        {
                                                                // On peut valider le fichier et le stocker définitivement
                                                                move_uploaded_file($_FILES['monfichier']['tmp_name'], $image);
                                                                chmod ($image, 0755);
                                                                echo "L'envoi a bien été effectué !";
                                                        }else{
                                                            echo "L'envoi a echoué.";
                                                        }
                                                }
                                        }

                                        $creer_compte_joueur=array();

                                        $creer_compte_joueur['prenom']=$_POST['prenom'];
                                        $creer_compte_joueur['nom']=$_POST['nom'];
                                        $creer_compte_joueur['login']= $_POST['login'];
                                        $creer_compte_joueur['password']= $_POST['password'];
                                        $creer_compte_joueur['profil']="joueur";
                                        $creer_compte_joueur['photo']= $_FILES['monfichier']['name'];
                                        $creer_compte_joueur['score']="0";
                                        $creer_compte_joueur['reponse_donner']="";

                                        $js= file_get_contents('utilisateur.json');

                                        $js= json_decode($js, true);

                                        $js[]= $creer_compte_joueur;

                                        $js= json_encode($js);

                                        file_put_contents('utilisateur.json', $js);

                                        header ('Location:index.php');
                                    }
                            }
                }
        }

?>

    <?php
        if (isset($_SESSION['user']['prenom']) && ($_SESSION['user']['nom'])){
    ?>
                <div class="titre_1">
                    <h1><strong>S'INSCRIRE</strong></h1>
                    <br>
                    <p>Pour proposer des quizz</p>
                </div>

                <div class="ligne_droite_admin">
                    <hr>
                </div>
    <?php
    }else{
    ?>
            <div class="inscription_joueur">
                <div class="titre_2">
                    <h1><strong>S'INSCRIRE</strong></h1>
                    <br>
                    <p>Pour tester votre niveau de culture général</p>
                </div>

                <div class="ligne_droite_joueur">
                    <hr>
                </div>
    <?php
    }
    ?>

                <form method="POST" action="" id="form-inscription" enctype="multipart/form-data">
                
                    <div class="label_prenom_utilisateur">
                        <label for="prenom" name="prenom">Prenom</label> <br>
                        <input type="text" name="prenom" id="prenom" error="error-3" placeholder="Aaaaa" value="<?php if(isset($_POST['prenom'])) { echo $_POST['prenom']; } ?>">
                    </div>
                    <br>
                    <br>
                    
                    

                    <div class="label_nom_utilisateur">
                        <label for="nom" name="nom">Nom</label>
                        <input type="text" name="nom" id="nom" error="error-4" placeholder= "BBBBB" value="<?php if(isset($_POST['nom'])) { echo $_POST['nom']; } ?>">
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    
                    
                
                    <div class="label_login_utilisateur">
                        <label for="login" name="login">Login</label>
                        <input type="text" name="login" id="login" error="error-5" placeholder= "aaabb"value="<?php if(isset($_POST['login'])) { echo $_POST['login']; } ?>">                        
                    </div>
                    <br>
                    <br>
                    <br>
                    
                    

                    <div class="label_password_utilisateur">
                        <label for="password" name="password">Password</label>
                        <input type="password" name="password" id="password" error="error-6" placeholder= "• • • • • • • • • • • • • • • • •" value="<?php if(isset($_POST['password'])) { echo $_POST['password']; } ?>">
                    </div>
                    <br>
                    <br>
                    
                    
                    <div class="label_confirm_utilisateur">
                        <label for="confirm" name="confirm">Confirm Password</label>
                        <input type="password" name="confirm" id="confirm" error="error-7" placeholder= "• • • • • • • • • • • • • • • • •" value="<?php if(isset($_POST['confirm'])) { echo $_POST['confirm']; } ?>">
                    </div>
                    <br>
                    

                    <div class="envoi_fichier">
                            <input type="file" name="monfichier" id="imag" onchange="previewImage(event)"/>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <div class="submit_creer_compte_utilisateur">
                        <a href="interface_joueur.php">
                            <input type="submit" name="creer_compte" value="Creer un compte">
                        </a>
                    </div>
                    <br>

                </form>
                <span class="erreur"><strong>   <?php if (isset($msg_erreur)){ echo  $msg_erreur;} ?>   </strong></span>

        <?php
            if (isset($_SESSION['user']['prenom']) && ($_SESSION['user']['nom'])){
        ?>
        <div class="avatar-inscription-admin">

            <div class="donnees_avatar">
                <img src="<?php if (isset($_SESSION['user']['photo'])){ echo $_SESSION['user']['photo'];}?>" id="im" class="image-ronde-avatar">
                    <div class="nom_prenom_avatar">
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

        </div>
        <?php
            }else{
        ?>
                <div class="avatar-inscription-joueur">
                    <div class="donnees_avatar">
                        <img src="<?php if (isset($_SESSION['user']['photo'])){ echo $_SESSION['user']['photo']; }?>" id="im" class="image-ronde-avatar">
                    </div>
                </div>
        <?php
            }
        ?>

    </div>

    <script>
    function previewImage(event)
    {
        var reader=new FileReader();
        var imageField=document.getElementById("im")
        reader.onload=function()
        {
            if(reader.readyState==2)
            {
                imageField.src=reader.result;
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
    
                



    
<script>
    const inputs= document.getElementsByTagName("input");
    for (input of inputs){
        input.addEventListener("keyup",function(e){
           if (e.target.hasAttribute("error")){
               var idDivError=e.target.getAttribute("error");
               document.getElementById(idDivError).innerText=""
           }
        })
    }
    document.getElementById("form-inscription").addEventListener("submit",function(e){
        const inputs= document.getElementsByTagName("input");
        var error=false;
        for (input of inputs){
            if (input.hasAttribute("error")){
                var idDivError=input.getAttribute("error");
            if (!input.value){
                document.getElementById(idDivError).innerText="Ce champ est obligatoire."
                error=true
            }
            
            }
        }

        if(error){
            e.preventDefault();
            return false;
        }
           
    })
</script>




<style>

.inscription_joueur {
    float:left;
    width: 85%;
    height: 100%;
    margin-top: 0%;
    left: 7.5%;
    position: relative;
    background-color: white;
}

#form-inscription{
    float: right;
    right: 67%;
    width: 30%;
    top: 15%;
    height: 350px;
    position: absolute;
}

.titre_1 {float: left; width: 30%; height: 15%;margin-top: 0%; margin-left: 3%; position: relative;}
.titre_1 h1 {float: left; font-size: 20px;margin-top: 0%; margin-bottom: 0%; color: black;}
.titre_1 p {float: left; font-size: 14px; margin-top: 0%; color: rgb(88, 87, 87);}

.titre_2 {float: left; width: 25%; height: 15%; margin-bottom: 0%; margin-left: 3%; position: relative;}
.titre_2 h1 {float: left; font-size: 20px;margin-top: 0%; margin-bottom: 0%; color: black;}
.titre_2 p {float: left; font-size: 14px; margin-top: 0%; color: rgb(88, 87, 87); position: relative;}

.ligne_droite_admin {float: left; width: 40%; margin-top: 6%; right: 30%; color: rgb(88, 87, 87); position: relative;}

.ligne_droite_joueur {float: left; width: 40%; margin-top: 6%; right: 25%; color: rgb(88, 87, 87); position: relative;}


.label_prenom_utilisateur {float: left; width: 100%; height: 55px; right: 0%; left: 3%; position: relative;}
.label_prenom_utilisateur label {font-size: 15px; color: rgb(88, 87, 87);}
.label_prenom_utilisateur input {width: 100%; height: 60%; border: 1px solid rgb(88, 87, 87); border-radius: 5px;}

.label_nom_utilisateur {float: left;width: 100%; height: 55px; right: 0%; margin-top: 0%; margin-left: 3%; position: relative;}
.label_nom_utilisateur label {float: left; font-size: 16px; color: rgb(88, 87, 87);}
.label_nom_utilisateur input {float: left; width: 100%; height: 60%; border: 1px solid rgb(88, 87, 87); border-radius: 5px;}

.label_login_utilisateur {float: left; width: 100%; height: 55px; right: 0%; margin-top: 3%; margin-left: 3%; position: relative;}
.label_login_utilisateur label {float: left; font-size: 16px; color: rgb(88, 87, 87);}
.label_login_utilisateur input {float: left; width: 100%; height: 60%; border: 1px solid rgb(88, 87, 87); border-radius: 5px;}

.label_password_utilisateur {float: left; width: 100%; height: 55px; right: 0%; margin-top: 0%; margin-left: 3%; position: relative;}
.label_password_utilisateur label {float: left; font-size: 16px; color: rgb(88, 87, 87);}
.label_password_utilisateur input {float: left; width: 100%; height: 60%; border: 1px solid rgb(88, 87, 87); border-radius: 5px;}

.label_confirm_utilisateur {float: left; width: 100%; height: 55px; right: 0%; margin-top: 0%; margin-left: 3%; position: relative;}
.label_confirm_utilisateur label {float: left; font-size: 16px; color: rgb(88, 87, 87);}
.label_confirm_utilisateur input {float: left; width: 100%; height: 60%; border: 1px solid rgb(88, 87, 87); border-radius: 5px;}

.envoi_fichier {width: 50%; height: 5%; margin-left: 30%; margin-top: 0%; position: relative;}

.submit_creer_compte_utilisateur {width: 60%; height: 7%; margin-left: 10%; margin-top: 0%; border-radius: 8px; position: relative;}
.submit_creer_compte_utilisateur input {float: left; width: 100%; height: 100%; border-radius: 5px; background-color: rgb(61, 191, 196);}

.erreur {margin-top: 28%; margin-left: 10%; color: red;}

.avatar-inscription-admin {
    float: right;
    width: 50%;
    height: 50%;
    left: 60%;
    bottom: 40%;
    margin-top: 0%;
    position: absolute;
}

.avatar-inscription-joueur {
    float: right;
    width: 50%;
    height: 50%;
    margin-top: 0%;
    position: relative;
}

.donnees_avatar{
    width: 100%;
    height: 100%;
    position: relative;
}

.image-ronde-avatar {
    float: left; 
    width : 150px; 
    height : 150px; 
    left: 25%; 
    margin-top: 0.5%; 
    border: none; 
    -moz-border-radius : 75px; 
    -webkit-border-radius : 75px; 
    border-radius : 75px;
    border: 2px solid darkturquoise;
}

.nom_prenom_avatar p{
    float: left;
    bottom: 0%;
    right: 68%;
    text-align: center;
    position: absolute;
    color: black;
}
</style>
               