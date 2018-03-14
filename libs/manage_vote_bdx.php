<?php

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//CALCUL RESULTATS
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function build_resultats_bdx($votes, $columns, $total_votes){
	$res = array();

	foreach($votes as $vote){
		$tem = new resultat_liste($vote);
		$tem->build_base_votes($vote, $columns);
		$tem->build_perc_votes($total_votes);
		$tem->build_cumul_votes();
		$tem->complete_resultat();
		$res[$tem->id_liste] = $tem;
	}

	return $res;	
}

function sort_by_mention_maj($to_sort){
	
	function best_mention_maj($a, $b){
		$men_a = $a['mention_majoritaire'];
		$men_b = $b['mention_majoritaire'];
		
		if($men_a == $men_b){return 0;}
		return ($men_a < $men_b) ? -1 : 1;
	}
	
	usort($to_sort, "best_mention_maj");
	return $to_sort;
}

function get_best_ids($resultats){
	function sort_by_mention_maj_desc($to_sort){

		function worst_mention_maj($a, $b){
			$men_a = $a->mention_maj;
			$men_b = $b->mention_maj;

			if($men_a == $men_b){return 0;}
			return ($men_a > $men_b) ? -1 : 1;
		}

		//usort fais seulement un tri ascendant
		//usort part worst_mention correspond donc a faire best_mention descendant
		usort($to_sort, "worst_mention_maj");
		return $to_sort;
	}
	$res = array();

	$sorted_res = sort_by_mention_maj_desc($resultats);
	$last_index = max(array_keys($sorted_res));
	$first_index = min(array_keys($sorted_res));

	$cnt = $first_index;
	$res[] = $sorted_res[$cnt]->id_liste;
	$best_mention = $sorted_res[$cnt]->mention_maj;

	$cnt = $cnt + 1;
	while(($cnt <= $last_index) && ($sorted_res[$cnt]->mention_maj == $best_mention)){
		$res[] = $sorted_res[$cnt]->id_liste;
		$cnt = $cnt + 1;
	}

	return $res;
}

function define_winner($equal_ids, $resultats){
	$first_index = min(array_keys($equal_ids));
	if (count($equal_ids) >= 2){

		while(count($equal_ids) > 1){
			$first_index = min(array_keys($equal_ids));
			$cnt_bigger = $first_index;
			$best_score = 0;
			
			foreach($equal_ids as $cnt=>$id){
				$resultat = $resultats[$id];
				$part = $resultat->biggest_part;

				if(abs($part) > abs($best_score)){
					$best_score = $part;
					$cnt_bigger = $cnt;
				}
			}

			if ($best_score > 0) {
				return $equal_ids[$cnt_bigger];
			}
			else{
				unset($equal_ids[$cnt_bigger]);
			}
		}
	
		$first_index = min(array_keys($equal_ids));
		return $equal_ids[$first_index];
	}
	else{
		return $equal_ids[$first_index];
	}

}

function get_mention_maj($cumul_row){
	$last_index = max(array_keys($cumul_row));
	$first_index = min(array_keys($cumul_row));

	for ($mention = $last_index; $mention >= $first_index; $mention--) {
		if ($cumul_row[$mention] > 50) {
			return $mention;
		}
	}
}

class resultat_liste {
	public $nom_liste;
	public $id_liste;
	public $mention_maj;
	public $base_votes = array();
	public $perc_votes = array();
	public $cumul_votes = array();
	public $votes_inf;
	public $votes_sup;
	public $biggest_part;

	public function __construct($vote){
		$this->nom_liste = $vote['nom_liste'];
		$this->id_liste = $vote['id'];		
	}

	public function build_base_votes($vote, $col_names){
		foreach ($col_names as $i => $name){
			$this->base_votes[$i] = $vote[$name];
		}
	}

	public function build_perc_votes($total){
		foreach($this->base_votes as $i=>$amount){
			$this->perc_votes[$i] = round($amount * 100 / $total, 2);
		}
	}
	
	public function build_cumul_votes(){
		$last_index = max(array_keys($this->perc_votes));
		$first_index = min(array_keys($this->perc_votes));

		$this->cumul_votes[$last_index] = $this->perc_votes[$last_index];
		for($i = $last_index - 1; $i >= $first_index; $i--){
			$this->cumul_votes[$i] = $this->perc_votes[$i] + $this->cumul_votes[$i+1];
		}
	}
	
	private function calc_inf($m_maj){
		$first_index = min(array_keys($this->perc_votes));

		if ($m_maj == $first_index){
			$this->votes_inf = 0;
		}
		else{
			$this->votes_inf = 100 - $this->cumul_votes[$m_maj];
		}
	}

	private function calc_sup($m_maj){
		$last_index = max(array_keys($this->perc_votes));
		if ($m_maj == $last_index){
			$this->votes_sup = 0;
		}
		else{
			$this->votes_sup = $this->cumul_votes[$m_maj + 1];
		}
	}

	public function calc_biggest_part(){
		//on suppose qu'on a déjà calculé votes_sup et votes_inf
		if ($this->votes_inf > $this->votes_sup){
			$this->biggest_part = - $this->votes_inf;
		}
		else{
			$this->biggest_part = $this->votes_sup;
		}
	}

	public function complete_resultat(){
		$m_maj = get_mention_maj($this->cumul_votes);
		$this->mention_maj = $m_maj;
		$this->calc_inf($m_maj);
		$this->calc_sup($m_maj);
		$this->calc_biggest_part();
	}
	
}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//BUILD FORM
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

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

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//MAKE VOTE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


function build_votes_bdx($posted, $listes, $columns){
	/*Renvoie un array avec valeurs du type: res[liste_id] = 'passable'
	En ne considérant uniquement les valeurs de ce qui a été posté,
	dont les clés figurent dans les id de $listes

	Et ne renvoie que des termes figurant dans $columns (construit avec build_values())
	*/
	$res = array();
	foreach ($listes as $liste){
		$id = $liste['id'];
		
		//Check si les 2-3 ids de listes figurent dans le POST
		if (!array_key_exists($id, $posted)){
			return '';
		}
		else{
			$value = $posted[$id];
		}		

		//Check si la valeur du POST pour chaque id est bien dans les valeurs possibles
		if (!array_key_exists($value, $columns)){
			return '';
		}
		else{
		$res[$id] = $columns[$value];
		}
	}
	return $res;
}

?>