<?php
ini_set("memory_limit","110016M");
include_once('simple_html_dom.php');
/**
 * Valorant scraper
 * Author: Danil Kholodnyy
 */
class scraper
{
	public $url;
	function __construct()
	{
		$this->url = "https://www.vlr.gg/matches";
	}
	public function parsing($data_type = "all"){
		if ($data_type == "all"){
			$html = file_get_html($this->url);
			$urls = new ArrayObject(array());
		    foreach($html->find('.wf-card') as $found) {
				// Found at least one.
				$return = true;
				$i = 0;
				foreach($html->find('a') as $found) {
					if ($i > 13){
					$urls->append($found->href);
					}
					$i++;
				}
				break;
		    }
		    
		    // clean up memory
		    $html->clear();
		    unset($html);

		    return $urls;
		}
	}
	public function get_tour_json($tours){
		$i = 0;
		$data = "";
		foreach ($tours as $tour){
			$match_id = explode("/", $tour)[1];
			$html = file_get_html('https://www.vlr.gg'.$tour);
			$result_form = $html->find('.match-header-vs')[0];
			$result_date = preg_replace('/\s+/', '', $html->find('.match-header-date')[0]->plaintext);
			//get form
			$status = preg_replace('/\s+/', '', $result_form->find('.match-header-vs-score')[0]->find('.match-header-vs-note')[0]->plaintext);
			if ($status != 'live'){
				$logo_comand1 =  $result_form->find('img')[0]->src;
				$logo_comand2 =  $result_form->find('img')[1]->src;
				$comand1 = preg_replace('/\s+/', '', $result_form->find('.wf-title-med')[0]->plaintext);
				$comand2 = preg_replace('/\s+/', '', $result_form->find('.wf-title-med')[1]->plaintext);
			}else{
				$comand1 = preg_replace('/\s+/', '', $result_form->find('.wf-title-med')[0]->plaintext);
				$comand2 = preg_replace('/\s+/', '', $result_form->find('.wf-title-med')[1]->plaintext);
				$score = preg_replace('/\s+/', '', $result_form->find('.js-spoiler ')[0]->plaintext);
				$logo_comand1 =  $result_form->find('img')[0]->src;
				$logo_comand2 =  $result_form->find('img')[1]->src;
			}
			//return data
			if ($status == 'live'){
				if ($data == ""){
				$data = $data.'{"status": "'.$status.'", "id":"'.$match_id.'", "date": "'.$result_date.'", "opponents": [{"name":"'.$comand1.'", "status": "wait", "score": "'.explode(":", $score)[0].'", "logo": "'.$logo_comand1.'"}, {"name":"'.$comand2.'", "status": "wait", "score": "'.explode(":", $score)[1].'", "logo": "'.$logo_comand2.'"}]}';
				}else{
				$data = $data.',{"status": "'.$status.'", "id":"'.$match_id.'", "date": "'.$result_date.'", "opponents": [{"name":"'.$comand1.'", "status": "wait", "score": "'.explode(":", $score)[0].'", "logo": "'.$logo_comand1.'"}, {"name":"'.$comand2.'", "status": "wait", "score": "'.explode(":", $score)[1].'", "logo": "'.$logo_comand2.'"}]}';
				}
			}else if ($status != 'live'){
				if ($data == ""){
				$data = $data.'{"status": "wait", "date": "'.$status.'", "opponents": [{"name":"'.$comand1.'", "status": "wait", "score": "0", "logo": "'.$logo_comand1.'"}, {"name":"'.$comand2.'", "status": "wait", "score": "0", "logo": "'.$logo_comand2.'"}]}';
				}else{
					$data = $data.',{"status": "wait", "date": "'.$status.'", "opponents": [{"name":"'.$comand1.'", "status": "wait", "score": "0", "logo": "'.$logo_comand1.'"}, {"name":"'.$comand2.'", "status": "wait", "score": "0", "logo": "'.$logo_comand2.'"}]}';
				}
			}
			if ($i >= 4){
				break;
			}
			$i++;
		}
		$html->clear();
		unset($html);
		return '{"game":"valorant", "timestamp": "'.time().'", "tours": ['.$data.']}';
	}
	public function get_tour_page($tour){
		$i = 0;
		$data = "";
		$html = file_get_html('https://www.vlr.gg/'.$tour.'/?game=all&tab=overview');
		$result_form = $html->find('.match-header-vs')[0];
		$result_date = $html->find('.match-header-date')[0]->plaintext;
		//get form
		$status = preg_replace('/\s+/', '', $result_form->find('.match-header-vs-score')[0]->find('.match-header-vs-note')[0]->plaintext);
		$comand1 = $result_form->find('.wf-title-med')[0]->plaintext;
		$comand2 = $result_form->find('.wf-title-med')[1]->plaintext;
		$score = $result_form->find('.js-spoiler ')[0]->plaintext;
		//data table
		$table = $html->find('.vm-stats-container ')[0]->find('.vm-stats-game ')[1];

		//$table_data = $table->find("tbody")[0]->find("tr")[0]->find(".mod-player")[0]->find("a")[0]->find(".text-of")[0]->plaintext;

		$data_table = "";
		$data_table2 = "";


		//comand 1
		$stat_com_1 = "";
		foreach ($html->find('.vm-stats-container ')[0]->find('.vm-stats-game ') as $map) {
			if (array_key_exists(0, $map->find('.vm-stats-game-header'))){
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.mod-t'))){
					$map_stat_score_t = $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.mod-t')[0]->plaintext;
				} 
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.mod-ct'))){
					$map_stat_score_ct = $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.mod-ct')[0]->plaintext;
				}
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.score'))){
					$map_stat_score = $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.score ')[0]->plaintext;
				}
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.team-name'))){
					$map_stat_t1 = $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.team-name')[0]->plaintext;
				}
				$map_stat_score_ot = $map->find('.vm-stats-game-header')[0]->find('.team')[0]->find('.mod-ot');
				if (array_key_exists(0, $map_stat_score_ot)){
					$map_ot = $map_stat_score_ot[0]->plaintext;
				}else{
					$map_ot = "";
				}
				if ($stat_com_1 == ""){
				$stat_com_1 = $stat_com_1.'{"comand_name": "'.$map_stat_t1.'", "map_name": "'.$map->find('.vm-stats-game-header')[0]->find('.map ')[0]->find("span")[0]->plaintext.'", "score": "'.$map_stat_score.'", "score_t": "'.$map_stat_score_t.'", "score_ct": "'.$map_stat_score_ct.'", "score_ot": "'.$map_ot.'"}';
				}else{
				$stat_com_1 = $stat_com_1.',{"comand_name": "'.$map_stat_t1.'", "map_name": "'.$map->find('.vm-stats-game-header')[0]->find('.map ')[0]->find("span")[0]->plaintext.'", "score": "'.$map_stat_score.'", "score_t": "'.$map_stat_score_t.'", "score_ct": "'.$map_stat_score_ct.'", "score_ot": "'.$map_ot.'"}';
				}
			}else{
				continue;
			}
		}
		$stat_com_2 = "";
		foreach ($html->find('.vm-stats-container ')[0]->find('.vm-stats-game ') as $map) {
			if (array_key_exists(0, $map->find('.vm-stats-game-header'))){
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.mod-t'))){
					$map_stat_score_t = $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.mod-t')[0]->plaintext;
				} 
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.mod-ct'))){
					$map_stat_score_ct = $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.mod-ct')[0]->plaintext;
				}
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.score'))){
					$map_stat_score = $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.score ')[0]->plaintext;
				}
				if (array_key_exists(0, $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.team-name'))){
					$map_stat_t1 = $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.team-name')[0]->plaintext;
				}
				$map_stat_score_ot = $map->find('.vm-stats-game-header')[0]->find('.team')[1]->find('.mod-ot');
				if (array_key_exists(0, $map_stat_score_ot)){
					$map_ot = $map_stat_score_ot[0]->plaintext;
				}else{
					$map_ot = "";
				}
				if ($stat_com_2 == ""){
				$stat_com_2 = $stat_com_2.'{"comand_name": "'.$map_stat_t1.'", "map_name": "'.$map->find('.vm-stats-game-header')[0]->find('.map ')[0]->find("span")[0]->plaintext.'", "score": "'.$map_stat_score.'", "score_t": "'.$map_stat_score_t.'", "score_ct": "'.$map_stat_score_ct.'", "score_ot": "'.$map_ot.'"}';
				}else{
				$stat_com_2 = $stat_com_2.',{"comand_name": "'.$map_stat_t1.'", "map_name": "'.$map->find('.vm-stats-game-header')[0]->find('.map ')[0]->find("span")[0]->plaintext.'", "score": "'.$map_stat_score.'", "score_t": "'.$map_stat_score_t.'", "score_ct": "'.$map_stat_score_ct.'", "score_ot": "'.$map_ot.'"}';
				}
			}else{
				continue;
			}
		}

		foreach ($table->find('.wf-table-inset')[0]->find("tbody")[0]->find("tr") as $tb){
			$data_table_cm1 = ["name" => $tb->find(".mod-player")[0]->find("a")[0]->find(".text-of")[0]->plaintext, "acs" => $tb->find(".mod-stat")[0]->plaintext, "k" => $tb->find(".mod-stat")[1]->plaintext, "d" => str_replace('/', "", $tb->find(".mod-stat")[2]->plaintext), "a" => $tb->find(".mod-stat")[3]->plaintext, "mp" => $tb->find(".mod-stat")[4]->plaintext, "adr"=> $tb->find(".mod-stat")[5]->plaintext, "hs" => $tb->find(".mod-stat")[6]->plaintext, "fk" => $tb->find(".mod-stat")[7]->plaintext, "fd" => $tb->find(".mod-stat")[8]->plaintext, "pm" => $tb->find(".mod-stat")[9]->plaintext];
			if ($data_table == ""){
				$data_table = $data_table.json_encode($data_table_cm1);
			}else{
				$data_table = $data_table.','.json_encode($data_table_cm1);
			}
		}
		foreach ($table->find('.wf-table-inset')[1]->find("tbody")[0]->find("tr") as $tb){
		$data_table_cm2 = ["name" => $tb->find(".mod-player")[0]->find("a")[0]->find(".text-of")[0]->plaintext, "acs" => $tb->find(".mod-stat")[0]->plaintext, "k" => $tb->find(".mod-stat")[1]->plaintext, "d" => str_replace('/', "", $tb->find(".mod-stat")[2]->plaintext), "a" => $tb->find(".mod-stat")[3]->plaintext, "mp" => $tb->find(".mod-stat")[4]->plaintext, "adr"=> $tb->find(".mod-stat")[5]->plaintext, "hs" => $tb->find(".mod-stat")[6]->plaintext, "fk" => $tb->find(".mod-stat")[7]->plaintext, "fd" => $tb->find(".mod-stat")[8]->plaintext, "pm" => $tb->find(".mod-stat")[9]->plaintext];
			if ($data_table2 == ""){
				$data_table2 = $data_table2.json_encode($data_table_cm2);
			}else{
				$data_table2 = $data_table2.','.json_encode($data_table_cm2);
			}
		}
		$logo_comand1 =  $result_form->find('img')[0]->src;
		$logo_comand2 =  $result_form->find('img')[1]->src;
		$data = ["score" => explode(":", $score)[1], "logo_cm1" => $logo_comand1, "logo_cm2" => $logo_comand2, "result_date" => $result_date, "status" => $status];
		//return data
		if ($status == 'live'){
			if ($data == ""){
			$data = '{"score_cm1": "'.explode(":", $score)[0].'", "score_cm2": "'.explode(":", $score)[1].'", "logo_cm1": "'.$logo_comand1.'", "c_1": "'.$comand1.'", "c_2": "'.$comand2.'", "logo_cm2": "'.$logo_comand2.'", "result_date": "'.$result_date.'", "comand_1": ['.$stat_com_1.'], "comand_2": ['.$stat_com_2.'], "status": "'.$status.'", "comand_table_1": ['.$data_table.'], "comand_table_2": ['.$data_table2.']}';
			}else{
			$data = '{"score_cm1": "'.explode(":", $score)[0].'", "score_cm2": "'.explode(":", $score)[1].'", "logo_cm1": "'.$logo_comand1.'", "c_1": "'.$comand1.'", "c_2": "'.$comand2.'", "logo_cm2": "'.$logo_comand2.'", "result_date": "'.$result_date.'", "comand_1": ['.$stat_com_1.'], "comand_2": ['.$stat_com_2.'], "status": "'.$status.'", "comand_table_1": ['.$data_table.'], "comand_table_2": ['.$data_table2.']}';
			}
		}else if ($status != 'live'){
			$data = '{"score_cm1": "'.explode(":", $score)[0].'", "score_cm2": "'.explode(":", $score)[1].'", "logo_cm1": "'.$logo_comand1.'", "c_1": "'.$comand1.'", "c_2": "'.$comand2.'", "logo_cm2": "'.$logo_comand2.'", "result_date": "'.$result_date.'", "comand_1": ['.$stat_com_1.'], "comand_2": ['.$stat_com_2.'], "status": "'.$status.'", "comand_table_1": ['.$data_table.'], "comand_table_2": ['.$data_table2.']}';
		}
		$data = str_replace('\t', "", $data);
		$data = str_replace('	', "", $data);
		$html->clear();
		unset($html);
		return $data;
	}
}

?>