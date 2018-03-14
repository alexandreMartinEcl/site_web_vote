<?php

error_reporting(E_ERROR); // enlever les messages 'deprecated'...
session_start();

include("libs/config.php");
include("libs/maLibSQL.pdo.php");
include("libs/maLibUtils.php");
include("libs/maLibCA.php");


function upload_file_from_b64($path, $b64_data){
	list($type, $b64_data) = explode(';', $b64_data);
	list(, $b64_data)      = explode(',', $b64_data);
	$file_data = base64_decode($b64_data);
	
	return file_put_contents($path, $file_data);
}

function motivation_path($id){
	return "motivations/".$id.".txt";
}

function picture_path($id){
	return "images/cand_".$id;
}

$action = valider("action", "POST");
$authen_ca = valider('authentifie_ca', 'SESSION');

$data = array();
if ($authen_ca && $action) { 
	switch($action) {
		case "getSessions" :
		$res = sql_get_sessions();
		$data["feedback"] = "ok";
		$data["sessions"] = $res;
		break;

		case "getListes" :
		$res = sql_get_listes();
		$data["feedback"] = "ok";
		$data["listes"] = $res;
		break;

		case "getCandidatsCA" :
		$res = sql_get_candidats_CA();
		$data["feedback"] = "ok";
		$data["candidats"] = $res;
		break;


		case "addSession" :
		$type = valider("type", "POST");
		$date = valider("date", "POST");
		$h_debut = valider("h_debut", "POST");
		$h_fin = valider("h_fin", "POST");

		if($type && $date && $h_debut && $h_fin) {
			$res = sql_add_session($type, $date, $h_debut, $h_fin);
			$data["feedback"] = "ok";
			$data["id"] = $res;
		}
		break;

		case "addListe" :
		$nom = valider("nom", "POST");
		if($nom) {
			$res = sql_add_liste($nom);
			$data["feedback"] = "ok";
			$data["id"] = $res;
		}
		break;

		case "addCandidatCA" :
		$nom = valider("nom", "POST");
		$college = valider("college", "POST");
		$img = valider("pic", "POST");
		$motiv = valider("motiv", "POST");
		if($nom && $college && $img && $motiv) {
			$res = sql_add_candidat_CA($nom, $college);
			$data["feedback"] = "ok";
			$data["id"] = $res;

			$data["motiv"] = upload_file_from_b64(motivation_path($res), $motiv);
			$data["img"] = upload_file_from_b64(picture_path($res), $img);
		}
		break;

		case "delSession" :
		$id = valider("id", "POST");
		if ($id) {
			$res = sql_del_session($id);
			$data["feedback"] = "ok";
		}
		break;

		case "delListe" :
		$id = valider("id", "POST");
		if ($id) {
			$res = sql_del_liste($id);
			$data["feedback"] = "ok";
		}
		break;

		case "delCandidatCA" :
		$id = valider("id", "POST");
		if ($id) {
			$res = sql_del_candidat_CA($id);
			$data["feedback"] = "ok";

			$data["del_motiv"] = unlink(motivation_path($id));
			$data["del_pic"] = unlink(picture_path($id));
		}
		break;

	}
}

echo json_encode($data);

function sql_get_sessions(){
	$SQL = "SELECT *";
	$SQL .= " FROM creneau";
	return parcoursRs(SQLSelect($SQL));
}

function sql_get_listes(){
	$SQL = "SELECT *";
	$SQL .= " FROM votes_bdx";
	return parcoursRs(SQLSelect($SQL));
}

function sql_get_candidats_CA(){
	$SQL = "SELECT *";
	$SQL .= " FROM votes_ca";
	$SQL .= " ORDER BY college";
	return parcoursRs(SQLSelect($SQL));
}

function sql_add_session($type, $date, $h_debut, $h_fin){
	$SQL = "INSERT INTO creneau(type, date, heure_debut, heure_fin)";
	$SQL .= " VALUES('$type', '$date', '$h_debut', '$h_fin')";
	return SQLInsert($SQL);
}

function sql_add_liste($nom){
	$SQL = "INSERT INTO votes_bdx (nom_liste)";
	$SQL .= " VALUES('$nom')";
	return SQLInsert($SQL);
}

function sql_add_candidat_CA($nom, $college){
	$SQL = "INSERT INTO votes_ca(nom, college, votes)";
	$SQL .= " VALUES('$nom', '$college', 0)";
	return SQLInsert($SQL);
}

function sql_del_session($id){
	$SQL = "DELETE FROM creneau";
	$SQL .= " WHERE id='$id'";
	return SQLDelete($SQL);
}

function sql_del_liste($id){
	$SQL = "DELETE FROM votes_bdx";
	$SQL .= " WHERE id='$id'";
	return SQLDelete($SQL);
}

function sql_del_candidat_CA($id){
	$SQL = "DELETE FROM votes_ca";
	$SQL .= " WHERE id='$id'";
	return SQLDelete($SQL);
}

?>
