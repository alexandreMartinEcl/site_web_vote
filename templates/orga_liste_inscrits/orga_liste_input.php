			<h2>Identification de l'inscrit</h2>
			<p>Veuillez rentrer 
			<?php 
			if (isset($_POST['identification']) and $_POST['identification'] == 'non') {
				echo 'à nouveau';
			} ?>
			le nom de famille du votant :</p>

			<form action="index.php?view=orga_ajout_paiement" method="post">
				<p>
				<input type="text" name="surname" /> 
				<input type="submit" value="Valider" />
				</p>
			</form> 
