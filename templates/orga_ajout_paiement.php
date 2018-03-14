<?php
/* On ne donne accès au contenu de la page que si l'utilisateur est authentifié membre du CA */
$authen_orga = valider('authentifie_orga', 'SESSION');
$creneau = "event";//check_login_available();

if ($creneau !== "event") {
	echo "<h3>Pas de créneau de vente actuellement. En cas de souci, vérifier avec le respo web du CA.</h3>";
} elseif ($authen_orga) {
	// identification du cotisant dans la BDD
	$id_post = valider('identification', 'POST');
	if (!$id_post or $id_post == 'non') { 

		$payer_cotis = valider("payer_cotisant", "POST");
		$payer_exte = valider("payer_exte", "POST");
		
		$payer_ids = array();
		if($payer_cotis){array_push($payer_ids, $payer_cotis);}
		if($payer_exte){array_push($payer_ids, $payer_exte);}

		$annuler_inscrit = valider("annuler_inscrit", "POST");
		
		if(!empty($payer_ids)){
			update_a_paye($payer_ids);
			include('templates/orga_liste_inscrits/orga_liste_done.php');
		}
		elseif($annuler_inscrit){
			$is_cotisant = valider("is_cotisant", "POST");
			if($is_cotisant == 1){
				delete_inscription($annuler_inscrit, true);
			}
			elseif($is_cotisant == 0){
				delete_inscription_exte($annuler_inscrit, true);
			}
			include('templates/orga_liste_inscrits/orga_liste_done.php');
		}
		else{
			/* Si l'utilisateur n'a pas encore rentré le nom du cotisant */
			$inscrit_surname = valider('inscrit_surname', 'POST');
			$cotis_surname = valider('cotis_surname', 'POST');
			if (!$inscrit_surname && !$cotis_surname){
				include('templates/orga_liste_inscrits/orga_liste_input.php');
			}

			/* L'utilisateur a rentré le nom du cotisant */
			else {
				// On récupère les entrées (les cotisants) qui ont le nom entré par l'utilisateur
				if ($inscrit_surname) {
					$people = get_inscrits($inscrit_surname);

					/* Si le nom saisi n'est pas dans la BDD*/
					if (count($people) == 0) { 
						include('templates/orga_liste_inscrits/orga_liste_fail.php');
					}
					/* Si le nom de l'utilisateur est dans la BDD : on lui demande de valider son prénom et son année (au cas où il y en aurait plusieurs */
					else {
						include('templates/orga_liste_inscrits/orga_liste_choice.php');
					} 

				} elseif ($cotis_surname) {
					$people = get_votants($cotis_surname);

					/* Si le nom saisi n'est pas dans la BDD*/
					if (count($people) == 0) { 
						include('templates/orga_liste_inscrits/orga_liste_cotis_fail.php');
					}
					/* Si le nom de l'utilisateur est dans la BDD : on lui demande de valider son prénom et son année (au cas où il y en aurait plusieurs */
					else {
						include('templates/orga_liste_inscrits/orga_liste_cotis_choice.php');
					} 
				}
			}
		}
	}

	// L'identification est faite
	else {
		$mode = valider("mode", 'POST');

		if ($mode === "inscrit") {
			// On obtient les infos sur l'inscrit
			$inscrit = get_inscrit_with_id($id_post);
			if($inscrit["id_garant"] == 0){
				$exte = sql_select_inscrit_exte($inscrit["id_cotisant"]);
				if(!empty($exte)){
					$exte = $exte[0];
				}
		
			}

//debug
/*		echo '</br>';
		echo 'votant:';
		print_r($votant);
*/

			// Si Le cotisant a déjà voté : il ne peut pas revoter
			if ($inscrit['a_paye'] == '1') { 
				include('templates/orga_liste_inscrits/orga_liste_a_paye.php');
			}

			// Si Le cotisant n'a pas encore voté, il peut mettre son vote dans l'urne
			else {
				include('templates/orga_liste_inscrits/orga_liste_doit_payer.php');
			}
		} elseif ($mode === "cotisant") {
			// On regarde si le cotisant identifié a déjà voté ou non
			$votant = get_votant_with_id($id_post);
//debug
/*		echo '</br>';
		echo 'votant:';
		print_r($votant);
*/
			$mdp = sql_get_mdp($id_post);
			include('templates/orga_liste_inscrits/orga_liste_cotis_mdp.php');
		}

	}
	include("templates/_message_fermer_session_ca.php");
}


// Si l'uilisateur n'est pas passé par 'identification_ca' (et n'a pas saisi le mdp du CA)
else { 
	include('templates/ca_id/orga_id_cheat.php');
} 
?>