<?php
			$mdp_post = valider('mot_de_passe', 'POST');
			// on regarde si l'utilisateur a voté
			$votant = get_votant_with_id($requested_id)[0];
			$_SESSION['a_vote'] = $donnees['a_vote'];


			// On récupère le nom des deux listes
			if($type_vote == 'bdx'){
				$candidates = get_candidates_bdx();

				if ($_SESSION['a_vote'] == 0) { 
					// Vote de l'utilisateur
					$values = build_values();
					$choices = build_choices();				
	
					// Traitement du vote de l'utilisateur
	
					if (!$mdp_post) {
						include("templates/vote_process/vote/voting.php");
					}
					elseif ($mdp_post !== $mdp) {
						include("templates/vote_process/vote/voting.php");
						echo "<p>Le mot de passe que vous avez rentré n'est pas celui que nous vous avons envoyé. Veuillez réessayer.</p>\n";
					}
					else {
						$_SESSION['reinitialisation'] = 1; // Pour que la machine de l'utilisateur puisse servir pour le vote d'une autre personne
						$votes = build_votes_bdx($_POST, $candidates, $values);
	
						if ($votes){
							include("templates/vote_process/vote/vote_done_msg.php");
							make_vote_bdx($votes, $_SESSION['id']);
						}
						else{
							die("Wrong POST request, are you trying to cheat ?");
						}
					}					
				}
				// Si l'utilisateur a déjà voté, on l'empêche de le faire une seconde fois
				else {
					$_SESSION['reinitialisation'] = 1;
					include("templates/id_result/votant_id_deja_vote.php");
				}
			}
			elseif($type_vote == 'ca'){
				$candidates = get_candidates_ca($_SESSION['college']);
				$id_blanc = get_id_blanc($_SESSION['college']);

				if(count($candidates)==0){
					include("templates/vote_process/vote/no_candidate.php");
				}
				elseif ($_SESSION['a_vote'] == 0) { 	
					// Traitement du vote de l'utilisateu
					if (!$mdp_post) {
						include("templates/vote_process/vote/voting.php");
					}
					elseif ($mdp_post !== $mdp) {
						include("templates/vote_process/vote/voting.php");
						echo "<p>Le mot de passe que vous avez rentré n'est pas celui que nous vous avons envoyé. Veuillez réessayer.</p>\n";
					}
					else {
						$_SESSION['reinitialisation'] = 1; // Pour que la machine de l'utilisateur puisse servir pour le vote d'une autre personne
						$votes = build_votes_ca($_POST, $candidates, $id_blanc);

						if ($votes){
							include("templates/vote_process/vote/vote_done_msg.php");
							make_vote_ca($votes, $_SESSION['id']);
						}
						else{
							die("Wrong POST request, are you trying to cheat ?");
						}
					}	
				}
				// Si l'utilisateur a déjà voté, on l'empêche de le faire une seconde fois
				else {
					$_SESSION['reinitialisation'] = 1;
					include("templates/id_result/votant_id_deja_vote.php");
				}
			}
			elseif($type_vote == 'event'){
				// Traitement du vote de l'utilisateur

				if(!array_key_exists("is_inscrit", $_SESSION)){
					$_SESSION["is_inscrit"] = check_inscrit($_SESSION['id']);
				}

				if (!$mdp_post) {
					include("templates/vote_process/inscription/subscribing.php");
				}
				elseif ($mdp_post !== $mdp) {
					include("templates/vote_process/inscription/subscribing.php");
					echo "<p>Le mot de passe que vous avez rentré n'est pas celui que nous vous avons envoyé. Veuillez réessayer.</p>\n";
				}
				else {
					$_SESSION['reinitialisation'] = 1; // Pour que la machine de l'utilisateur puisse servir pour le vote d'une autre personne
					switch($_POST["inscription_modif"]){
					
						case "cancel":
							delete_inscription($_SESSION["id"], false);
							include("templates/vote_process/inscription/delete_done_msg.php");
							break;
						case "cancel_exte":
							delete_inscription_exte($_SESSION["id"], false);
							include("templates/vote_process/inscription/delete_exte_done_msg.php");
							break;
						case 'modif_crea':
							$inscrits = build_inscription($_POST);
							
							if ($inscrits){
								make_inscription($inscrits);
								include("templates/vote_process/inscription/inscription_done_msg.php");
							}
							else{
								die("Wrong POST request, are you trying to cheat ?");
							}
							break;
						default:
							die("Wrong POST request, are you trying to cheat ?");
							break;
					}
				}
			}
	?>