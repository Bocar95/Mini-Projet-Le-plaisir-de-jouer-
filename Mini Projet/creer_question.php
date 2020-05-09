<!-- PARTIE PHP --> <!-- PARTIE PHP --> <!-- PARTIE PHP --> <!-- PARTIE PHP --> <!-- PARTIE PHP -->
<?php

    $reponses_possible=array(
        'multiple'=>array(),
        'simple'=>array(),
        'text'=>array()
    );

    $bonne_reponse=array(
        'multiple'=>array(),
        'simple'=>array(),
        'text'=>array(),
    );

    $msg="null";


    // VALIDATION BACK END AVEC PHP..................................................................

    $i=1;

    if (isset($_POST['question']) && !empty($_POST['question'])){
        $qusetion=  $_POST['question'];
        if (isset($_POST['nbr_point']) && !empty($_POST['nbr_point'])){
            $nbr_point= $_POST['nbr_point'];
            if (isset($_POST['type_reponse']) && !empty($_POST['type_reponse'])){
                $type_reponse= $_POST['type_reponse'];
    //ON MET TOUS LES TYPES DE REPONSES DANS UN TABLEAU ET LES BONNES REPONSES CHOISI DANS UN AUTRE TABLEAU..............................
                if ($type_reponse=== "multiple"){
                    while (isset($_POST['Reponse_'.$i]) && !empty($_POST['Reponse_'.$i])){
                        array_push($reponses_possible['multiple'], $_POST['Reponse_'.$i]); 
                        if (isset($_POST['checkbox_'.$i])){
                            array_push($bonne_reponse['multiple'], $_POST['Reponse_'.$i]);
                        }else{
                            array_push($bonne_reponse['multiple'], $msg);
                        }
                        $i++;
                    }
                }else
                    if ($type_reponse=== "simple"){
                        while (isset($_POST['Reponse_'.$i]) && !empty($_POST['Reponse_'.$i])){
                            array_push($reponses_possible['simple'], $_POST['Reponse_'.$i]);
                            if (!empty($_POST['radio_']) && $_POST['radio_']==$i){
                                array_push($bonne_reponse['simple'], $_POST['Reponse_'.$i]);
                            }else{
                                array_push($bonne_reponse['simple'], $msg);
                            }
                            $i++;
                        }
                    }else
                        if ($type_reponse=== "text"){
                            if (!empty($_POST['Reponse_text'])){
                                array_push($reponses_possible['text'], $_POST['Reponse_text']);
                            }
                        }
    //ON MET LES DONNEES DANS UN FICHIER JSON..................................................................................
                if (isset($_POST['button-creer-question'])){
                    $creer_question= array();
            
                    $creer_question['question']= $_POST['question'];
                    $creer_question['nbr_point']= $_POST['nbr_point'];
                    $creer_question['type_reponse']= $_POST['type_reponse'];
            
                    if ($creer_question['type_reponse'] == "multiple"){
                        if (!empty($reponses_possible['multiple'])){
                            $creer_question['reponses_possible']= $reponses_possible['multiple'];
                            $creer_question['bonnes_reponses']= $bonne_reponse['multiple'];

                            $js= file_get_contents('questions.json');
                            $js= json_decode($js, true);
                    
                            $js[]= $creer_question;
                    
                            $js= json_encode($js);
                            file_put_contents('questions.json', $js);
                        }
                    }
                    if ($creer_question['type_reponse'] == "simple"){
                        if (!empty($reponses_possible['simple'])){
                            $creer_question['reponses_possible']= $reponses_possible['simple'];
                            $creer_question['bonnes_reponses']= $bonne_reponse['simple'];

                            $js= file_get_contents('questions.json');
                            $js= json_decode($js, true);
                    
                            $js[]= $creer_question;
                    
                            $js= json_encode($js);
                            file_put_contents('questions.json', $js);
                        }
                    }
                    if ($creer_question['type_reponse'] == "text"){
                        if (!empty($reponses_possible['text'])){
                            $creer_question['reponses_possible']= $reponses_possible['text'];
                            $creer_question['bonnes_reponses']= $bonne_reponse['multiple'];

                            $js= file_get_contents('questions.json');
                            $js= json_decode($js, true);
                        
                            $js[]= $creer_question;
                        
                            $js= json_encode($js);
                            file_put_contents('questions.json', $js);
                        }
                    }
            
            
                    
        
                }
            }
        }
    }
    
?>



<!-- PARTIE HTML --> <!-- PARTIE HTML --> <!-- PARTIE HTML --> <!-- PARTIE HTML --> <!-- PARTIE HTML --> <!-- PARTIE HTML -->         


        <div class="header-zone-liste-joueurs">
            <div class="title-header-zone-liste-joueurs">
                <p><b>PARAMÉTRER VOTRE QUESTION<b></p>
            </div>
        </div>

        <div class="body-zone-liste-joueurs">
            <div class="cadre-zone-liste-joueurs">
                <form action="" method="POST" id="creer_questions">

                    <label for="question">Question
                        <input type="text-area" name="question" id="question" error="error" placeholder="Veuillez saisir une question sur ce champ" class="question">
                        <div class="error-form" id="error"></div>
                    </label>

                    <br>

                    <label for="points">Nbre de Point
                        <select name="nbr_point" value="nbr_point" for="nbr_point" class="nbr_point">
                            <option value="1">1</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </label>
                    <br>
                    <br>
                    <div class="zone_type" id="row_0">
                        <label for="type">Type de réponse
                            <select name="type_reponse" id="type_reponse">
                                <option value="" selected>Choisir le type de reponse</option>
                                <option name="multiple" value="multiple" id="multiple">Multiple</option>
                                <option name="simple" value="simple" id="simple">Simple</option>
                                <option name="text" value="text" id="text">Texte</option>
                            </select>
                            <button type="button" name="button-plus" id="button-plus"  class="btn btn-reponse">+</button>
                        </label>
                    </div>
                    
                    <div id="inputs">
                    </div>

                    <div class="footer-zone-liste-joueurs">
                        <button type="submit" name="button-creer-question" class="button-creer-question" id="creer_questions">Enregistrer</button>
                    </div>

                </form>
            </div>
        </div>



<!-- PARTIE JAVASCRIPT --><!-- PARTIE JAVASCRIPT --> <!-- PARTIE JAVASCRIPT --> <!-- PARTIE JAVASCRIPT --> <!-- PARTIE JAVASCRIPT -->


<script>
    var nbrRow= 0;
    var i=0;

    document.getElementById("button-plus").addEventListener("click",

    function textBoxCreate(){
        nbrRow++;
        var divInputs= document.getElementById('inputs');
        var newInput= document.createElement('div');
        var deleteInput= document.getElementById('button-plus');
        var selectOptions= document.getElementById('type_reponse');
        newInput.setAttribute('class', 'row');
        newInput.setAttribute('id', 'row_'+nbrRow);

        if (selectOptions.value==="multiple") {
           
            newInput.innerHTML= ` 
                            <input type="text" name="Reponse_${nbrRow}" error="error_${nbrRow}" class="champ" placeholder="Reponse_${nbrRow}">
                            <input type="checkbox" name="checkbox_${nbrRow}" class="btn btn-checkbox">
                            
                            <button type="button" onclick="onDeleteInput(${nbrRow})" class="btn btn-supprimer"><img src="images/ic-supprimer.png"></button>
                            <br>
                            <div class="error-form" id="error_${nbrRow}"></div>
                            `;
            divInputs.appendChild(newInput);
            i++;
        }

        if (selectOptions.value==="simple") {
            newInput.innerHTML= ` 
                            <input type="text" name="Reponse_${nbrRow}" error="error_${nbrRow}" class="champ" placeholder="Reponse_${nbrRow}">
                            <input type="radio" name="radio_" class="btn btn-radio" value="${nbrRow}">
                           
                            <button type="button" onclick="onDeleteInput(${nbrRow})" class="btn btn-supprimer"><img src="images/ic-supprimer.png"></button>
                            <br>
                            <div class="error-form" id="error_${nbrRow}"></div>
                            `;
        divInputs.appendChild(newInput);
        i++;
        }

        if (selectOptions.value==="text") {
            deleteInput.remove();
            newInput.innerHTML= ` 
                            <input type="text" name="Reponse_text" error="error_${nbrRow}" class="champ" placeholder="Reponse_text">
                            <button type="button" onclick="onDeleteInput(${nbrRow})" class="btn btn-supprimer"><img src="images/ic-supprimer.png"></button>
                            <br>
                            <div class="error-form" id="error_${nbrRow}"></div>
                            `;
        divInputs.appendChild(newInput);
        i++;
        }

    })

    function onDeleteInput(n){
        var target= document.getElementById('row_'+n);
        target.remove();
        alert ('Ce champ va être supprimer');
        i--;
    }


    const inputsGenerer= document.getElementsByTagName("input");
            for (input of inputsGenerer){
                input.addEventListener("keyup",function(e){
                if (e.target.hasAttribute("error")){
                    var idDivGenererError=e.target.getAttribute("error");
                    document.getElementById(idDivGenererError).innerText=""
                }
                })
            }
            document.getElementById("creer_questions").addEventListener("submit",function(e){
              
                const inputsGenerer= document.getElementsByTagName("input");
               

                var error=false;
                for (input of inputsGenerer){
                    
                    if (input.hasAttribute("error")){
                        var idDivGenererError=input.getAttribute("error");
                        if (!input.value){
                               document.getElementById(idDivGenererError).innerText="Ce champ est obligatoire."
                                error=true
                        }
                    } 
                }

            if(error){
                    e.preventDefault();
                      return false;
                    }
    })

    //validation cote front... //validation cote front...  //validation cote front...  //validation cote front... 

</script>













<style>

.header-zone-liste-joueurs {
    width: 100%;
    height: 12%;
    border-radius: 5px 5px;
    background-color: white;
}

.title-header-zone-liste-joueurs {
    width: 65%;
    height: 70%;
    top: 30%;
    left: 22%;
    position: relative;
}

.title-header-zone-liste-joueurs p {
    display: inline;
    font-size: 25px;
    color: darkturquoise;
}

.body-zone-liste-joueurs {
    width: 100%;
    height: 76%;
    background-color: white;
}

.cadre-zone-liste-joueurs {
    width: 94%;
    height: 95%;
    top: 2%;
    left: 2.5%;
    border: 1px solid darkturquoise;
    border-radius: 10px 10px 10px 10px;
    position: relative;
}

.error-form {
    position: relative;
    color: red;
    left: 20%;
    width: 100%;
    font-weight: bold;
}

.error-form-generer {
    position: relative;
    color: red;
    height: 10px;
    left: 10%;
    width: 100%;
    font-weight: bold;
}

.question {
    position: relative;
    width: 50%;
    left: 9%;
    margin-top: 1%;
}

.nbr_point {
    position: relative;
    width: 7%;
    left: 3%;
}

.type_reponse {
    position: relative;
}

.footer-zone-liste-joueurs {
    width: 100%;
    height: 12%;
    border-radius: 0px 0px 5px 5px;
}

.button-creer-question {
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

.btn {
    padding:0px 2px 0px 2px ;
    margin-right:3%;
    font-weight:10;
    border:2px solid gray;
    color:#fff;
    box-shadow:0 0 10px gray;
    margin-bottom:10px;
    margin-top:5px;
    cursor:pointer;
}

.btn-reponse {
    background-color:darkturquoise;
}

.champ {
    width: 70%;
    margin-left: 10%;
    font-size: 20px;
    border-radius: 6px;
    background-color: whitesmoke;
    border: 2px solid navajowhite;
    text-align: center;
}

.row {
    float: left;
    width: 90%;
}

.btn-supprimer {
}

.btn-radio {
    position: relative;
}

#inputs{
width:95%;
height:165px;
float:left;
margin-left: 2%;
border:1px solid #000;
border-radius:4px;
overflow: auto;
box-shadow:0 0 5px #000;
margin-top:5px;
text-align:center
}

/* Voici la mise en forme pour les erreurs */
.error {
  width  : 100%;
  padding: 0;
 
  font-size: 80%;
  color: white;
  background-color: #900;
  border-radius: 0 0 5px 5px;
 
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.error.active {
  padding: 0.3em;
}


</style>