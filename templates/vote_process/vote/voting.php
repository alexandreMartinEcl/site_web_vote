			<h2>Vote</h2>
			<p>Vous allez ici pouvoir évaluer les différents candidats :</p>
			<p> </br> </p>

			<?php
			if($type_vote == "ca"){
				include("templates/vote_process/vote/msg_ca.php");
			}
			?>
			
			<form id='vote_form' action="index.php?view=votant_id" method="post">
				<?php

				if($type_vote == "bdx"){
					complete_form_bdx($candidates, $choices);
				}
				else{
					complete_form_ca($candidates, $choices, $_SESSION['college']);
				}
				?>

				<h2>Authentification</h2>
				<p>Pour que ton vote soit valide, un mail a été envoyé sur votre boite mail centralienne. Ce mail contient un mot de passe. Veuillez entrer ce mot de passe ci-dessous :
				</p>
				<p>
					<input type="text" name="mot_de_passe" />
				</p>

				</br>
				<input type="submit" value="Valider" />
			</form>
