<?php
require_once('fonctions.php');
    if (isset($_POST['btn_submit'])){
        $login=$_POST['login'];
        $pwd=$_POST['pwd'];
        $result= connexion($login, $pwd);
        $page=1;
        $msg_erreur="";

        if ($result=="error"){
            $msg_erreur= "login ou mot de passe incorrect";
        }else{
            header ("location:index.php?lien=".$result."&page=".$page);
        }
    }

?>




<div class="container">

    <div class="container-header">
        <div class="title">Login Form</div>
    </div>

    <div class="container-body">
        <form action="" method="POST" id="form-connexion">

            <div class="input-form">
                <div class="icon-form icon-form-login"></div>
                <input type="text" class="form-control" error="error-1" name="login" id="" placeholder="Login">
                <div class="error-form" id="error-1"></div>
            </div>

            <div class="input-form">
                <div class="icon-form icon-form-password"></div>
                <input type="password" class="form-control" error="error-2" name="pwd" id="" placeholder="Password">
                <div class="error-form" id="error-2"></div>
            </div>

            <div class="input-form">
                <button type="submit" class="btn-form" name="btn_submit" id="">Connexion</button>
                <a href="index.php?lien=inscription" class="link-form">S'inscrire pour jouer?</a>
            </div>

            <span class="erreur"><strong>   <?php if (isset($msg_erreur)){ echo  $msg_erreur;} ?>   </strong></span>

        </form>
    </div>
</div>



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
    document.getElementById("form-connexion").addEventListener("submit",function(e){
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

