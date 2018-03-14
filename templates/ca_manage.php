<script src="libs/manage_CE.js"></script>
<script>
function startCEManage(){
    afficherListes();
    afficherCandidatsCA();
    afficherSessions();
}

</script>


<?php
/* On ne donne accès au contenu de la page que si l'utilisateur est authentifié membre du CA */
$authen_ca = valider('authentifie_ca', 'SESSION');
if ($authen_ca) { 
    echo  "\n<body onload='startCEManage()'>";

    echo "\n<h2>Voici sessions de vote et d'inscription</h2>";
    echo "\n<div id='div_sessions'></div>";

    echo "\n<h2>Voici les candidats aux élection BDX</h2>";
    echo "\n<div id='div_listes'></div>";

    echo "\n<h2>Voici les candidats aux élection au CA élèves</h2>";
    echo "\n<div id='div_candidats_CA'></div>";

    echo  "\n</body>";
    
}
else { 
	include('templates/ca_id/ca_id_cheat.php');
} 

?>