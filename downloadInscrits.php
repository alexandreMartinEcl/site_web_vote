<?php
session_start();
include_once("libs/maLibCA.php");
include_once("libs/config.php");

GLOBAL $CONFIG_MDP_ORGA;

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$authen_orga = valider('authentifie_orga', 'SESSION');
$mdp_orga = valider('mdp', 'POST') ? valider('mdp', 'POST') : $obj['mdp'];
$output_type = valider('type', 'POST') ? valider('type', 'POST') : $obj['type'];
$no_code = valider('no_code', 'POST') ? valider('no_code', 'POST') : $obj['no_code'];
$nfc_code = valider('nfc_code', 'POST') ? valider('nfc_code', 'POST') : $obj['nfc_code'];
$id_member = valider('id_member', 'POST') ? valider('id_member', 'POST') : $obj['id_member'];
$presents = valider('presents', 'POST') ? valider('presents', 'POST') : $obj['presents'];
$specificName = valider('specificName', 'POST') ? valider('specificName', 'POST') : $obj['specificName'];

if($authen_orga || ($mdp_orga && $mdp_orga === $CONFIG_MDP_ORGA)){
	if ($output_type == 'json') {
		if ($no_code) {
			$data = array();
			$data["success"] = true;
			$data["result"] = sql_select_inscrits_no_code();

			echo json_encode($data);
		} elseif ($specificName) {
			$data = array();
			$data["success"] = true;
			$data["result"] = sql_select_cotisant_for_app($specificName);

			echo json_encode($data);
		} elseif ($nfc_code) {
			$data = array();
			$data["success"] = true;
			sql_update_nfc($nfc_code, $id_member);
			echo json_encode($data);
		} elseif ($presents) {
			$data = array();
			$data["success"] = true;
			sql_update_presents($presents);
			echo json_encode($data);
		} else {
			$data = array();
			$data["success"] = true;
			$data["result"] = sql_select_inscrits();
	
			echo json_encode($data);
		}

	} else {
	
		$key = generate_res_key();
		$files = scandir("res");
	
		for($i=2; $i<count($files); $i++){
			unlink("res/".$files[$i]);
		}
	
		$filename = "res/temp_inscrits_" . $key . ".csv";
		sql_select_inscrits_csv($filename);
		header("Location: $filename");
	}
}
else{
	if ($output_type == 'json') {
		$data = array();
		$data["success"] = false;
		$data["message"] = "Wrong password";
		echo json_encode($data);			
	} else {
		include('templates/ca_id/orga_id_cheat.php');
	}
}
?>
