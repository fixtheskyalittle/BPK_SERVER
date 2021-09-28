<?php
include_once('libs/simple_html_dom.php');
$id = $_GET['steam_id'];

if (isset($id)){
	$html = file_get_html('https://steamcommunity.com/miniprofile/'.$id.'.html');
	#$rsf = $html->find('.miniprofile_container');
	echo substr(preg_replace('/[^0-9:]/', '', $html->find('.miniprofile_game_details')[0]), 1);
}
?>