	<html>
		<h2>Espace orga</h2>
		<p>Bienvenue, brave organisateur de soirée dansante.</p>
		<p>Si tu gères les ventes de places : <a href="index.php?view=orga_ajout_paiement" style="color:blue";>clique ici</a> pour 
		gérer un paiement.</p>
		<p>Pour télécharger le csv des inscrits : <a href="downloadInscrits.php" target="_blank" style="color:blue";> clique ici</a>
		<p>Pour télécharger La torche 48 : <a href="La-torche-48.apk" target="_blank" style="color:blue";> clique ici</a>
		
		<?php
			echo "<p>". count(sql_select_inscrits()) . " personnes ont payé leur place.</p>";
			echo "<p>". count(sql_select_all_inscrits()) . " personnes se sont préinscrits.</p>";
		?>
	</html>
