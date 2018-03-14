<?php

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//BUILD FORM
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

/*
function complete_form_bdx($listes, $choices){
	foreach ($listes as $liste) {
		$list_name = $liste['nom_liste'];
		$id = $liste['id'];
		echo "\n<p>$list_name :</p>";
	
		$nb_choices = count($choices);
		for ($i = 1 ; $i <= $nb_choices ; $i++) {
			// On ajoute le vote pour la liste
	// majoritaire			$boo_checked = ($i == round($nb_choices / 2)); //checked pour la valeur 'moyenne'
			$boo_checked = ($choices[$i] === "Blanc");
			make_radio_balise($id, $i, $choices[$i], $boo_checked);
		}
	
		echo '</br>';
	}
}

function make_radio_balise($name, $value, $to_print, $check=false){
	if ($check){
		$to_add = "checked ";
	}
	else{
		$to_add = "";
	}
	echo "\n<input type=radio name=$name value='$value' id='$value' " . $to_add . "/>\n";
	echo "<label>$to_print</label>";
}
*/

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//MAKE VOTE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function check_inscr_value($posted, $key){
	if (array_key_exists($key, $posted)){
		if(strlen($posted[$key].trim()) > 0){
			return true;
		}
	}
	return false;
}

function build_inscrit($id, $nom, $prenom, $cursus, $place, $mail, $bdate, $id_garant, $alcool){
	$now = get_date();
	$res = array();
	
	$anti_sqli = array("(", "'", ")", "=", "[", "]", "{", "}", "&", "|");

	$res["id"] = $id;
	$res["nom"] = str_replace($anti_sqli, "", $nom);
	$res["prenom"] = str_replace($anti_sqli, "", $prenom);
	$res["cursus"] = $cursus;
	$res["hebergement"] = str_replace($anti_sqli, "", $place);
	$res["mail"] = $mail;
	$res["date_naissance"] = str_replace($anti_sqli, "", $bdate);
	$res["id_garant"] = $id_garant;
	$res["alcool"] = $alcool === "avec" ? "avec" : "sans";
	$res["sub_date"] = $now["date"];
	$res["sub_time"] = $now["time"];
	
	return $res;
}

function build_inscription($posted){
	/*Renvoie un array avec valeurs du type: res[liste_id] = 'passable'
	En ne considérant uniquement les valeurs de ce qui a été posté,
	dont les clés figurent dans les id de $listes

	Et ne renvoie que des termes figurant dans $columns (construit avec build_values())
	*/
	$res = array();

	if(!check_inscr_value($posted, "cotis_place")){
		return "";
	}

	array_push($res, build_inscrit($_SESSION["id"], $_SESSION["nom"], $_SESSION["prenom"],
							$_SESSION["cursus"], $posted["cotis_place"], $_SESSION["mail"], $_SESSION["date_naissance"], 0, $posted["cotis_alcool"]));
	
	if($posted["add_exte"] === "true"){
		if(!check_inscr_value($posted, "exte_nom") || !check_inscr_value($posted, "exte_prenom")
			|| !check_inscr_value($posted, "exte_date_naissance") || !check_inscr_value($posted, "exte_place")){
			return "";
		}

		// ATTENTION: on ne vérifie pas la valiation de la date de naissance, elle est déjà vérifié sur le form via javascript
		// Quelqu'un peut donc simuler le même POST request, mais avec une date chelou
		// Flemme de faire la fonction de vérif (sans PHP5)
/*
		if(!validateDate($posted["exte_date_naissance"], 'dd/mm/yyyy')){
			echo "SALUT3";
			return "";
		}
*/
		array_push($res, build_inscrit(0, $posted["exte_nom"], $posted["exte_prenom"],
								"EXTE", $posted["exte_place"], $_SESSION["mail"], $posted["exte_date_naissance"], $_SESSION["id"], $posted["exte_alcool"]));
	}

	return $res;
}

?>