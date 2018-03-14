<?php
	$send_mail_again = valider('mail_resend', 'POST');

	//On vérifie que l'utilisateur n'a pas déjà voté
	if ($_SESSION['a_vote'] == 1) {
		$_SESSION['reinitialisation'] = 1;
		include("templates/vote_process/id_steps/deja_vote.php");
	}
	else{
		$mdp = sql_get_mdp($_SESSION['id']);
		// Si l'utilisateur n'a pas de mdp dans la BDD, 
		//on le crée et on l'envoie par mail à son adresse centralienne :
		if ($mdp === null ){
			$new_password = generate_password($_SESSION['prenom'], $_SESSION['nom']);
			update_mdp($new_password, $_SESSION['id']);
			include("libs/envoi_mail.php");
			envoi_mail($new_password, $_SESSION['mail']);
		}
		include("templates/vote_process/votant_mdp_vote.php");
	}
?>