			<h2>Identification du votant</h2>
			<p>Veuillez rentrer 
			<?php 
			if (isset($_POST['identification']) and $_POST['identification'] == 'non') {
				echo 'à nouveau';
			} ?>
			le nom de famille du votant :</p>

			<form action="index.php?view=ca_liste_votants" method="post">
				<p>
				<input type="text" name="surname" /> 
				<input type="submit" value="Valider" />
				</p>
			</form> 
