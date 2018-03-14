			<h2>Identification de l'inscrit</h2>
			<p>Veuillez entrer 
			<?php 
			if (isset($_POST['identification']) and $_POST['identification'] == 'non') {
				echo 'à nouveau';
			} ?>
			le nom de famille de l'inscrit :</p>

			<form action="index.php?view=orga_ajout_paiement" method="post">
				<p>
				<input type="text" name="inscrit_surname" /> 
				<input type="submit" value="Valider" />
				</p>
			</form> 

			<p>Si vous souhaitez donner son mot de passe à un cotisant n'ayant pas reçu son email :
			<p>Veuillez entrer ici
			<?php 
			if (isset($_POST['identification']) and $_POST['identification'] == 'non') {
				echo 'à nouveau';
			} ?>
			le nom de famille de l'inscrit :</p>

			<form action="index.php?view=orga_ajout_paiement" method="post">
				<p>
				<input type="text" name="cotis_surname" /> 
				<input type="submit" value="Valider" />
				</p>
			</form> 
