			<!-- corps de la page -->
			<?php
			/* Si jamais qqun a déjà voté sur la machine de l'utilisateur et qu'une autre personne veut le faire, et relance le process	
			(on réitinialise les données du vecteur $_SESSION qui concerne le votant) */
			
			$authentified_id = valider('id', 'SESSION');
			$requested_id = valider('identification', 'GET');
			$type_vote = check_login_available();
			if (!$type_vote){
//				include("templates/vote_process/inscription/subscribing.php");
				include("templates/vote_process/id_steps/login_forbidden.php");
			}
			else{
				$_SESSION['type_vote'] = $type_vote;
				// L'utilisateur n'est pas encore identifié
				if(!$authentified_id) {
					if (!$requested_id){
						$surname = valider('surname', 'POST');
						// Tant que l'utilisateur n'a pas rentré son nom, on le lui demande
						if (!$surname) {
							include("templates/vote_process/id_steps/first_input.php");
						}
						// L'utilisateur a rentré son nom
						else {
							// On récupère les entrées (personnes) qui ont le nom entré par l'utilisateur
							$people = get_votants($surname);
							// Si le nom de l'utilisateur n'est pas dans la BDD
							if (count($people) == 0) {
								include("templates/vote_process/id_steps/choice_fail.php");
							}
							// Si le nom de l'utilisateur est dans la BDD : on lui demande de valider son prénom et son année
							else{
								// Présentation des noms correspondant et premier choix
								include("templates/vote_process/id_steps/choice.php");
							}
						}
					}
					// L'utilisateur a choisit un nom dans la liste d'options (ou le "non")
					else {
						// Si l'utilisateur ne se reconnait pas dans la liste des personnes ayant le nom qu'il a rentré
						if ($requested_id == 'non') {
							include("templates/vote_process/id_steps/resp_no.php");
						}

						// Si l'utilisateur se reconnait
						else {
							create_session_with_id($requested_id);
							include("templates/vote_process/id_steps/session_built.php");
							include("templates/_message_fermer_session.php");
						}
					}
				} 
				/*L'utilisateur a été identifié ($_SESSION a été construit). 
				On lui a déjà demandé une première fois son mdp (password_votant), et il n'a pas encore été authentifié */
				else{
					include("templates/vote_process/id_steps/session_built.php");
					include("templates/_message_fermer_session.php");
				} 
			}
			?>
