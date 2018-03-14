<?php
/* On ne donne accès au contenu de la page que si l'utilisateur est authentifié membre du CA */
$authen_ca = valider('authentifie_ca', 'SESSION');
if ($authen_ca) { 
	// identification du cotisant dans la BDD
	$id_post = valider('identification', 'POST');
	if (!$id_post or $id_post == 'non') { 

		/* Si l'utilisateur n'a pas encore rentré le nom du cotisant */
		$surname = valider('surname', 'POST');
		if (!$surname){ 
			include('templates/ca_liste_votants/ca_liste_input.php');
		}

		/* L'utilisateur a rentré le nom du cotisant */
		else {
			// On récupère les entrées (les cotisants) qui ont le nom entré par l'utilisateur
			$people = get_votants($surname);

			/* Si le nom saisi n'est pas dans la BDD*/
			if (count($people) == 0) { 
				include('templates/ca_liste_votants/ca_liste_fail.php');
			}

			/* Si le nom de l'utilisateur est dans la BDD : on lui demande de valider son prénom et son année (au cas où il y en aurait plusieurs */
			else {
				include('templates/ca_liste_votants/ca_liste_choice.php');
			} 
		}
	}

	// L'identification est faite
	else {
		// On regarde si le cotisant identifié a déjà voté ou non
		$votant = get_votant_with_id($id_post);
		$a_vote = ( $votant['a_vote']);

//debug
/*		echo '</br>';
		echo 'votant:';
		print_r($votant);
*/

		// Si Le cotisant a déjà voté : il ne peut pas revoter
		if ($a_vote == '1') { 
			include('templates/ca_liste_votants/ca_liste_a_deja_vote.php');
		}

		// Si Le cotisant n'a pas encore voté, il peut mettre son vote dans l'urne
		else {
			$mdp = sql_get_mdp($id_post);
			include('templates/ca_liste_votants/ca_liste_peut_voter.php');
		}
	}
	include("templates/_message_fermer_session_ca.php");
}


// Si l'uilisateur n'est pas passé par 'identification_ca' (et n'a pas saisi le mdp du CA)
else { 
	include('templates/ca_id/ca_id_cheat.php');
} 
?>