		<h2>Authentification membre CE</h2>
		<p>Si vous êtes membre du CE, veuillez rentrer votre mot de passe pour accéder aux données relatives au vote :</p>

		<form action="index.php?view=ca_id" method="post">
			<p>
			<input type="password" name="password" /> <input type="submit" value="Valider" />
			</p>
		</form> 
<?php
	if ($mdp){
		echo "<p>Mauvais mot de passe</p>";
	}
?>