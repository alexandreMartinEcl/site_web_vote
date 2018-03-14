<script type="text/javascript">
	// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
	function isValidDate(dateString){
		// First check for the pattern
		let reg = new RegExp("^[1-2][0-9][0-9][0-9]\-[0-1][0-9]\-[0-3][0-9]$");
		if(!reg.test(dateString)){
			console.log(dateString);
			return false;
		}

		// Parse the date parts to integers
		var parts = dateString.split("-");
		var day = parseInt(parts[2], 10);
		var month = parseInt(parts[1], 10);
		var year = parseInt(parts[0], 10);

		// Check the ranges of month and year
		if(year < 1000 || year > 3000 || month == 0 || month > 12){
			console.log("a");
			return false;
		}

		var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

		// Adjust for leap years
		if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)){
			monthLength[1] = 29;
		}

		// Check the range of the day
		return day > 0 && day <= monthLength[month - 1];
	}

	function disp_non_cotisant(){
		let non_cotis = document.getElementById("exte");
		let bttn = document.getElementById("bttn_exte");
		let input_exte = document.forms["subs_form"]["add_exte"];

		if(non_cotis.style.display == "block"){
			non_cotis.style.display = "none";
			bttn.textContent = "Je me porte garant pour un exté";
			input_exte.value = false;
		}
		else{
			non_cotis.style.display = "block";
			bttn.textContent = "En fait nan oublie l'exté";
			input_exte.value = true;
		}
		console.log(document.forms["subs_form"]);
	}

	function validateForm(){
		let form = document.forms["subs_form"];
		if(form["cotis_place"].value.trim().length === 0){
			alert("Définis l'endroit où tu comptes dormir");
			return false;
		}

		if (form["add_exte"].value == "true") {
			if(form["exte_nom"].value.trim().length === 0
			|| form["exte_prenom"].value.trim().length === 0
			|| form["exte_date_naissance"].value.trim().length === 0
			|| form["exte_place"].value.trim().length === 0){
				alert("Formulaire pour l'exté incomplet");
				return false;
			}
			if(!isValidDate(form["exte_date_naissance"].value)){
				alert("Mauvais format pour le jour de naissance de l'exté ou date invalide");
				return false;
			}
		}

		return validateMdp(form);
	}

	function validateMdp(form){
		if(form["mot_de_passe"].value.trim().length === 0){
			alert("Pas de mot de passe");
			return false;
		}
		return true;
	}

</script>

			<h2>Inscription</h2>
			<p>Tu vas ici pouvoir t'inscrire, toi et une potentielle personne non-cotisante, à la prochaine soirée dansante :</p>
			<p> <br/> </p>
			
			<?php
				global $LIEN_PAIEMENT;
				
				if(isset($_SESSION["is_inscrit"]) && $_SESSION["is_inscrit"] !== "false"){
					echo "<h3>Tu t'es déjà inscrit, voilà les détails</h3>";
					$cotisant = $_SESSION["is_inscrit"]["cotisant"];
					echo "\n<div>Ton nom de famille : $cotisant[nom]</div>";
					echo "\n<div>Ton prénom : $cotisant[prenom]</div>";
					echo "\n<div>Ta date de naissance (aaaa-mm-jj): $cotisant[date_naissance]</div>";
					echo "\n<div>Avec ou sans alcool: $cotisant[alcool]</div>";
					echo "\n<div><label>Ton hébergement : $cotisant[hebergement]</div>";

					if($cotisant['a_paye'] == 0){
						echo "\n<form id=cancel_form action=index.php?view=votant_id onsubmit='return validateMdp(this)' method=post>";
						echo "\n<input type=hidden name=inscription_modif value='cancel'/>";
						echo '<input type="submit" value="J\'annule mon inscription" />';
						echo '<div>Mot de passe reçu par mail lors de ton inscription : <input type="text" name="mot_de_passe" /></div>';
						echo '</form>';
						if (strlen($LIEN_PAIEMENT) > 0) {
							echo "<p>Pour régler ta place, l'organisateur te propose de régler en ligne via le lien suivant:</p>";
							echo "<p><a href=$LIEN_PAIEMENT target='_blank'>$LIEN_PAIEMENT</a></p>";
						}
					}
					else{
						echo "<p>Ta place a déjà été réglée, tu ne peux pas annuler ton inscription (contacte l'organisateur si besoin).</p>";
					}
				
					if(array_key_exists("exte", $_SESSION["is_inscrit"])){
						echo "<h3>Tu as inscrit un exté, voilà ses détails</h3>";
						$exte = $_SESSION["is_inscrit"]["exte"];
						echo "\n<div><label>Son nom de famille : $exte[nom]</div>";
						echo "\n<div><label>Son prénom : $exte[prenom]</div>";
						echo "\n<div><label>Sa date de naissance (aaaa-mm-jj): $exte[date_naissance]</div>";
						echo "\n<div>Avec ou sans alcool: $cotisant[alcool]</div>";
						echo "\n<div><label>Son hébergement : $exte[hebergement]</div>";

						if($exte['a_paye'] == 0){
							echo "\n<form id=cancel_form action=index.php?view=votant_id onsubmit='return validateMdp(this)' method=post>";
							echo "\n<input type=hidden name=inscription_modif value='cancel_exte'/>";
							echo '<input type="submit" value="J\'annule l\'inscription de l\'exté uniquement" />';

							echo '<div>Mot de passe reçu par mail lors de ton inscription : <input type="text" name="mot_de_passe" /> </div>';
							echo '</form>';

							if (strlen($LIEN_PAIEMENT) > 0) {
								echo "<p>Pour régler sa place, l'organisateur te propose de régler en ligne via le lien suivant:</p>";
								echo "<p><a href=$LIEN_PAIEMENT target='_blank'>$LIEN_PAIEMENT</a></p>";
							}
						}
						else{
							echo "<p>Sa place a déjà été réglée, tu ne peux pas annuler son inscription (contacte l'organisateur si besoin).</p>";
						}
	
					}

					echo "\n<p> Pour modifier ces détails, complète le formulaire suivant (entièrement) et clique sur 'Je m'inscris'.</p>";
				}
			?>
			
			<form id='subs_form' action="index.php?view=votant_id" onsubmit="return validateForm()"  method="post">

				<h3>Ton inscription</h3>
				<?php
					echo "\n<div>Ton nom de famille : $_SESSION[nom]</div>";
					echo "\n<div>Ton prénom : $_SESSION[prenom]</div>";
					echo "\n<div>Ta date de naissance (aaaa-mm-jj): $_SESSION[date_naissance]</div>";
					echo "\n<div><label>Avec ou sans alcool : </label><input type=radio name=cotis_alcool value='avec' checked />Avec";
					echo "\n<input type=radio name=cotis_alcool value='sans'/>Sans</div>";
					echo "\n<div><label>Ton hébergement : </label><input type=text name=cotis_place value='$_SESSION[last_place]' /></div>";

					echo "\n<input type=hidden name=add_exte value=false />";
				?>
				
				</br>
				<button type="button" onClick="disp_non_cotisant();" id="bttn_exte">Je me porte garant pour un exté</button> 

				<div id="exte" style='display:none;'>
					<h3>Un non cotisant</h3>
					<p>Attention, en inscrivant une personne ne faisant pas partie de Centrale Lille Associations à la soirée dansante, tu te portes garant(e) pour elle</p>
					
					<div><label>Son nom de famille : </label><input type="text" name="exte_nom" /></div>
					<div><label>Son prénom : </label><input type="text" name="exte_prenom" /></div>
					<div><label>Sa date de naissance (aaaa-mm-jj) : </label><input type="text" name="exte_date_naissance"/></div>
					<div><label>Avec ou sans alcool : </label>
					<input type=radio name=exte_alcool value='avec' checked />Avec
					<input type=radio name=exte_alcool value='sans' />Sans
					</div>
					<div><label>Son hébergement : </label><input type="text" name="exte_place" /></div>				
				</div>
	
				<h2>Authentification</h2>
				<p>Pour que ton inscription soit valide, un mail a été envoyé sur votre boite mail centralienne. Ce mail contient un mot de passe. Veuillez entrer ce mot de passe ci-dessous :
				</p>
				<p>
					<input type="text" name="mot_de_passe" />
				</p>

				<br/>
				<br/>
				<input type=hidden name=inscription_modif value='modif_crea'/>
				<input type="submit" value="Je m'inscris" />
			</form>
