<?php
if (file_exists("libs/maLibSQL.php")){
	include("libs/maLibSQL.php");
}
if (file_exists("libs/maLibUtils.php")){
	include_once "libs/maLibUtils.php";
}
if (file_exists("libs/config.php")){
	include_once "libs/config.php";
}

function check_ce_mdp($mdp){
	global $CONFIG_MDP_CE;
	if($mdp==$CONFIG_MDP_CE){
		return True;
	}
	else{
		return False;
	}
}

function check_orga_mdp($mdp){
	global $CONFIG_MDP_ORGA;
	if($mdp==$CONFIG_MDP_ORGA){
		return True;
	}
	else{
		return False;
	}
}

function get_votant_with_id($id){
	$SQL = "SELECT id, prenom, nom, mail, cursus, college, date_naissance, a_vote";
	$SQL .= " FROM votants"; 
	$SQL .= " WHERE id = '$id'";
	return parcoursRS(SQLSelect($SQL))[0];
}

function get_inscrit_with_id($id){
	$SQL = "SELECT *";
	$SQL .= " FROM inscrit"; 
	$SQL .= " WHERE id = '$id'";
	return parcoursRS(SQLSelect($SQL))[0];
}

function sql_get_mdp($id){
	$SQL = "SELECT mot_de_passe";
	$SQL .= " FROM votants";
	$SQL .= " WHERE id = '$id'";
	$res = parcoursRS(SQLSelect($SQL))[0];
	return $res['mot_de_passe'];
}

function create_session_with_id($requested_id){
	$votant = get_votant_with_id($requested_id);

	$_SESSION['nom'] = $votant['nom'];
	$_SESSION['prenom'] = $votant['prenom'];
	$_SESSION['id'] = $votant['id'];
	$_SESSION['mail'] = $votant['mail'];
	$_SESSION['cursus'] = $votant['cursus'];
	$_SESSION['college'] = $votant['college'];
	$_SESSION['date_naissance'] = $votant['date_naissance'];
	$_SESSION['a_vote'] = $votant['a_vote'];
}

function reinit_session_if_need(){
	$reinit = valider('reinitialisation', 'SESSION');
	$reinit_post = valider('reinitialisation', 'POST');
	if ($reinit || $reinit_post) {
		unset($_SESSION['id']);
		unset($_SESSION['prenom']);
		unset($_SESSION['nom']);
		unset($_SESSION['mot_de_passe']);
		unset($_SESSION['a_vote']);
		unset($_SESSION['cursus']);
		unset($_SESSION['college']);
		unset($_SESSION['mail']);
		unset($_SESSION['reinitialisation']);
		unset($_SESSION['authentifie']);
		unset($_SESSION['authentifie_ca']);
		unset($_SESSION['authentifie_orga']);
		unset($_SESSION['is_inscrit']);
		unset($_SESSION['date_naissance']);
	}
}

function get_candidates_bdx(){
	$SQL = "SELECT id, nom_liste";
	$SQL .= " FROM votes_bdx";

	$SQL_res = parcoursRS(SQLSelect($SQL));
	
	$res = array();
	foreach($SQL_res as $liste){
		$res[$liste['id']] = $liste;
	}
	return $res;
}

function get_candidates_ca($college){
	$SQL = "SELECT id, nom, college";
	$SQL .= " FROM votes_ca";
	$SQL .= " WHERE college='$college' AND UPPER(nom) != 'BLANC'";
	
	$SQL_res = parcoursRS(SQLSelect($SQL));
	
	$res = array();
	foreach($SQL_res as $candidate){
		$res[$candidate['id']] = $candidate;
	}
	return $res;
}

function get_id_blanc($college){
	$SQL = "SELECT id";
	$SQL .= " FROM votes_ca";
	$SQL .= " WHERE college='$college' AND UPPER(nom) = 'BLANC'";
	
	$res = parcoursRS(SQLSelect($SQL))[0];	
	return $res['id'];
}

function get_votants($surname){
	$surname = $surname.'%';
	$SQL = "SELECT id, nom, prenom, cursus, college";
	$SQL .= " FROM votants"; 
	$SQL .= " WHERE nom LIKE '$surname'"; 
	return parcoursRS(SQLSelect($SQL));
}

function get_inscrits($name){
	$name = $name.'%';
	$SQL = "SELECT id, nom, prenom, cursus, id_garant, alcool";
	$SQL .= " FROM inscrit"; 
	$SQL .= " WHERE nom LIKE '$name' OR prenom LIKE '$name'"; 
	return parcoursRS(SQLSelect($SQL));
}

function generate_password($prenom, $nom){
	$initiales = substr($prenom, 0, 1) . substr($nom, 0, 1);
	$char = "abcdefghijklmnopqrstuvwxyz0123456789";
	$rand_caract = substr(str_shuffle($char), 0, 8);

	return $initiales . $rand_caract ;
}

function generate_res_key(){
	$char = "abcdefghijklmnopqrstuvwxyz0123456789";
	$rand_caract = substr(str_shuffle($char), 0, 8);
	return $rand_caract ;
}

function update_mdp($mdp, $id_votant){
	$SQL = "UPDATE votants";
	$SQL .= " SET mot_de_passe = '$mdp'";
	$SQL .= " WHERE id = '$id_votant'";
	SQLUpdate($SQL);
}


function build_values(){
	$res = array();
	$res[1] = 'a_rejeter';
	$res[2] = 'insuffisant';
	$res[3] = 'passable';
	$res[4] = 'assez_bien';
	$res[5] = 'bien';
	$res[6] = 'tres_bien';
	return $res;
}

/*
function build_values(){
	$res = array();
	$res[1] = 'nom_liste_1';
	$res[2] = 'nom_liste_2';
	$res[3] = 'blanc';
	return $res;
}
*/

function build_choices(){
	$res = array();
	$res[1] = 'A rejeter';
	$res[2] = 'Insuffisant';
	$res[3] = 'Passable';
	$res[4] = 'Assez bien';
	$res[5] = 'Bien';
	$res[6] = 'Tres bien';
	return $res;
}

/*
function build_choices(){
	$res = array();
	$res[1] = "Tsuna'lille";
	$res[2] = "Crysta'lille";
	$res[3] = "Blanc";
	return $res;
}
*/

function sql_add_vote($table, $id_list, $column, $to_add=1){
	$SQL = "UPDATE " . $table;
	$SQL .= " SET " . $column . "=" . $column . " + " . $to_add;
	$SQL .= " WHERE id ='$id_list';";
	return $SQL;
}

function sql_update_a_vote($id){
	$SQL = "UPDATE votants";
	$SQL .= " SET a_vote = 1";
	$SQL .= " WHERE id ='$id';";
	return $SQL;
}

function make_vote_bdx($list_votes, $id){
	$SQL = "";
	for ($i = 1 ; $i <= count($list_votes) ; $i++) {
		// On ajoute le vote pour la liste
		$SQL .= sql_add_vote("votes_bdx", $i, $list_votes[$i]);
	}
	// On enregistre fait que l'utilisateur ait voté
	$SQL .= sql_update_a_vote($id);
	
	SQLSeveralUpdate($SQL);
}

function make_vote_ca($cand_votes, $id){
	$SQL = "";
	for ($i = 0 ; $i < count($cand_votes) ; $i++) {
		// On ajoute le vote pour la liste
		$id_cand = array_keys($cand_votes)[$i];
		$SQL .= sql_add_vote("votes_ca", $id_cand, "votes", $cand_votes[$id_cand]);
	}
	// On enregistre fait que l'utilisateur ait voté
	$SQL .= sql_update_a_vote($id);
	
	SQLSeveralUpdate($SQL);
}

function sql_insert_inscrit_value($inscrit){
	return "('$inscrit[id]_$inscrit[id_garant]', '$inscrit[id]', '$inscrit[nom]',
					'$inscrit[prenom]', '$inscrit[cursus]',
					'$inscrit[hebergement]', '$inscrit[mail]',
					'$inscrit[date_naissance]', '$inscrit[id_garant]',
					'$inscrit[alcool]',
					'$inscrit[sub_date]', '$inscrit[sub_time]')";
}

function make_inscription($inscrits){
	$SQL = "INSERT INTO inscrit(`id`, `id_cotisant`, `nom`, `prenom`, `cursus`, `hebergement`, `mail`, `date_naissance`, `id_garant`, `alcool`, `sub_date`, `sub_time`)";
	$SQL .= " VALUES";
	foreach(array_values($inscrits) as $inscrit) {
		$SQLtemp = $SQL . sql_insert_inscrit_value($inscrit);
		$SQLtemp .= "ON DUPLICATE KEY UPDATE `nom`=VALUES(`nom`), `prenom`=VALUES(`prenom`),";
		$SQLtemp .= " `cursus`=VALUES(`cursus`), `hebergement`=VALUES(`hebergement`),";
		$SQLtemp .= " `date_naissance`=VALUES(`date_naissance`), `alcool`=VALUES(`alcool`), `sub_date`=VALUES(`sub_date`), `sub_time`=VALUES(`sub_time`);";

		SQLInsert($SQLtemp);
		//		$SQL .= ",";
	}
//	$SQL = substr($SQL, 0, -1);
//	$SQL .= "ON DUPLICATE KEY UPDATE `nom`=VALUES(`nom`), `prenom`=VALUES(`prenom`),";
//	$SQL .= " `cursus`=VALUES(`cursus`), `hebergement`=VALUES(`hebergement`),";
//	$SQL .= " `date_naissance`=VALUES(`date_naissance`), `alcool`=VALUES(`alcool`), `sub_date`=VALUES(`sub_date`), `sub_time`=VALUES(`sub_time`);";

	return true;
}

function sql_select_inscrit($id){
	$SQL = "SELECT *";
	$SQL .= " FROM inscrit";
	$SQL .= " WHERE id_cotisant='$id'";
	return parcoursRS(SQLSelect($SQL));
}

function sql_select_inscrit_exte($id_garant){
	$SQL = "SELECT *";
	$SQL .= " FROM inscrit";
	$SQL .= " WHERE id_garant='$id_garant'";
	return parcoursRS(SQLSelect($SQL));	
}

function check_inscrit($id){
	$cotis = sql_select_inscrit($id);
	if(!empty($cotis)){
		$res = array();
		$res["cotisant"] = $cotis[0];

		$exte = sql_select_inscrit_exte($id);
		if(!empty($exte)){
			$res["exte"] = $exte[0];
		}
		return $res;
	}
	return "false";
}

function delete_inscription($id_cotisant, $force){
	$to_add = "";
	if(!$force){
		$check_exte = sql_select_inscrit_exte($id_cotisant);
		if(!empty($check_exte)){
			$check_exte = $check_exte[0];
			if($check_exte['a_paye'] == 1){
				die("Vous ne pouvez pas annuler, vous vous portez garant pour quelqu'un qui a déjà payé sa place. Voyez avec l'organisateur.");
			}
		}
		$to_add = " AND a_paye = 0";
	}

	$SQL = "DELETE FROM inscrit";
	$SQL .= " WHERE (id_cotisant='$id_cotisant' OR id_garant='$id_cotisant')".$to_add;
	return SQLDelete($SQL);
}

function delete_inscription_exte($id_garant, $force){
	$to_add = "";
	if(!$force){
		$to_add = " AND a_paye = 0";
	}

	$SQL = "DELETE FROM inscrit";
	$SQL .= " WHERE id_garant='$id_garant'" . $to_add;
	return SQLDelete($SQL);	
}

function sql_add_ca_vote($id, $posted_vote, $columns){
	$SQL .= "UPDATE votes";
	$SQL .= " SET ";
	foreach($columns as $col){
		$amount = $posted_vote[$id .'_'. $col];
		if ($amount == ''){
			$amount = 0;
		}
		$SQL .= $col .'='. $col .' + '. $amount .', ';
	}
	$SQL = substr($SQL, 0, strlen($SQL) - 2);
	$SQL .= " WHERE id='$id';";
	return $SQL;
}

function make_ca_vote($posted_vote, $listes, $vote_values){
	$SQL = "";
	foreach ($listes as $liste) {
		$id = $liste['id'];
		$SQL .= sql_add_ca_vote($id, $posted_vote, $vote_values);
	}
	SQLSeveralUpdate($SQL);
}

function update_a_vote($id){
	SQLUpdate(sql_update_a_vote($id));
}

function update_a_paye($ids){
	$strids = join("', '", $ids);
	$SQL = "UPDATE inscrit";
	$SQL .= " SET a_paye = 1";
	$SQL .= " WHERE id IN('$strids');";
	return SQLUpdate($SQL);
}

function get_nb_cotisants(){
	$SQL = 'SELECT MAX(id) as res';
	$SQL .= ' FROM votants';
	$rows = parcoursRS(SQLSelect($SQL));
	return $rows[0]['res'];
}

function get_nb_votants(){
	$SQL = 'SELECT COUNT(*)';
	$SQL .= ' FROM votants';
	$SQL .= ' WHERE a_vote=1;';
	$res = parcoursRS(SQLSelect($SQL));
	return $res[0]['COUNT(*)'];
}

function get_resultats_bdx(){
	$SQL = 'SELECT *';
	$SQL .= ' FROM votes_bdx';
	return parcoursRS(SQLSelect($SQL));
}

function order_select_by_college($sql_res){
	$res = array();
	$tem_college = '';
	for($i = 0; $i < count($sql_res); $i++){
		$rw = $sql_res[$i];

		$rw_college = $rw['college'];
		$rw_id = $rw['id'];

		if($rw_college !== $tem_college){
			$tem_college = $rw_college;
			$res[$rw_college] = array();
		}

		$res[$rw_college][$rw_id] = $rw;
	}
	return $res;
}

function get_resultats_ca(){
	$SQL = 'SELECT *';
	$SQL .= ' FROM votes_ca';
	$SQL .= ' ORDER BY college';
	$res = parcoursRS(SQLSelect($SQL));
	return order_select_by_college($res);
}

function is_ca_vote_coherent($posted_vote, $listes, $vote_values){
	$nb_vote_test = 0;

	foreach($listes as $liste) {
		// Calcul du nb total de votes 
		$id = $liste['id'];
		$a = 0;
		foreach($vote_values as $value){
			$nb_votes = $posted_vote[$id.'_'.$value];
			$a += $nb_votes;
		}
		
		if (($nb_vote_test != 0) && ($a != $nb_vote_test)){
			return false;
		}
		else{
			$nb_vote_test = $a;
		}
	}
	return true;
}

function make_ca_vote_form($liste, $names_to_post, $cols_to_print){
	echo "<b>". $liste['nom_liste'] ." :</b>\n			";
	
	foreach($cols_to_print as $cnt=>$col){
		$name = $liste['id'].'_'.$names_to_post[$cnt];
		make_number_balise($name, $col);
	}
}

function make_number_balise($name, $to_print){
	echo '<p>'. $to_print .' : ';
	echo "<input type=number name=$name />";
	echo "</p>\n			";
}

function get_date(){
	$res = array();
	$date = getdate();
	$res["date"] = sprintf("%d-%d-%d", $date["year"], $date["mon"], $date["mday"]);
	$res["time"] = sprintf("%d:%d:%d", $date["hours"], $date["minutes"], $date["seconds"]);	
	return $res;
//test	return array("date"=>"2017-11-29", "time"=>"19:56:00");//$res;
}

function check_login_available(){
	$datetime = get_date();
//	print_r($datetime);
	$creneau = sql_select_closing_times($datetime["date"], $datetime["time"]);
//debug
/*
	echo 'session_creneau:';
	print_r($creneau);
*/
	if(count($creneau) == 0){
		return '';
	}
//	elseif(new DateTime($datetime["time"]) > new DateTime($creneau[0]["heure_fin_login"])){
		//return true;
//		return '';
//	}
	else{
		return $creneau['type'];
	}
}

function sql_select_closing_times($date, $time){
	$SQL = "SELECT *";
	$SQL .= " FROM creneau";
	$SQL .= " WHERE (date='$date')";
	$SQL .= " AND ('$time' >= heure_debut AND '$time' <= heure_fin)";
	$res = parcoursRS(SQLSelect($SQL))[0];
	return $res;
}

function sql_select_votants_csv($link){
	$SQL = "SELECT id, nom, prenom, cursus";
	$SQL .= " FROM votants";
	$SQL .= " WHERE a_vote=1";
	return parcoursRs_csv(SQLSelect($SQL), $link);
}

function sql_select_inscrits_csv($link){
	$SQL = "SELECT *";
	$SQL .= " FROM inscrit";
	return parcoursRs_csv(SQLSelect($SQL), $link);
}

?>
