<?php 
	/* Si l'utilisateur n'est pas authentifié comme membre du CA, cad s'il n'a pas rentré de mot de passe, ou s'il n'a pas rentré le bon */
	$mdp = valider('password', 'POST');
	$authen = valider('authentifie_ca', 'SESSION');

	if (!check_ce_mdp($mdp) and !$authen) { 
		include('templates/ca_id/ca_id_home.php');
	}

	/* Si l'utilisateur est authentifié comme membre du CA, il a accès à l'espace CA */
	else { 	
		if (!$authen) {
			$_SESSION['authentifie_ca'] = 1;
		}
		
		include('templates/ca_id/ca_authentified.php');
		include("templates/_message_fermer_session_ca.php");
	} 
?>
