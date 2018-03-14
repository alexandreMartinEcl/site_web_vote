		<h2>Authentification membre orga</h2>
		<p>Si vous êtes membre de l'équipe organisatrie de la prochaine soirée dansante, veuillez rentrer votre mot de passe pour accéder aux données relatives au vote :</p>

		<form action="index.php?view=orga_id" method="post">
			<p>
			<input type="password" name="password" /> <input type="submit" value="Valider" />
			</p>
		</form> 
<?php
	if ($mdp){
		echo "<p>Mauvais mot de passe</p>";
	}
?>