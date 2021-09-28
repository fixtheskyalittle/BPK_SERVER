<?php
$title = "Scoreboard - Panel";
$data = $_POST;
 
//если кликнули на button
if ( isset($data['do_signup']) )
{
// проверка формы на пустоту полей
    $errors = array();
    if ( trim($data['comand1']) == '' )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Enter Comand 1</div>';
    }
 
    if ( trim($data['comand2']) == '' )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Enter Comand 2</div>';
    }
 
    if ( $data['match_key'] == '' )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Enter Match Key</div>';
    }

    if ( R::count('csgo_match', "match_key = ?", array($data['match_key'])) > 0)
    {
        $errors[] = '<div class="alert alert-danger" role="alert">A match with this match key already exists!</div>';
    }
	R::ext('xdispense', function($table_name){
		return R::getRedBean()->dispense($table_name);
	});
    if ( empty($errors) )
    {
        //ошибок нет, теперь регистрируем
        $csmatch = R::xdispense('csgo_match');
        $csmatch->comand_1 = $data['comand1'];
        $csmatch->comand_2 = $data['comand2'];
        $csmatch->img1 = "none";
        $csmatch->img2 = "none";
        $csmatch->date_update = date("Y-m-d H:i:s");
        $csmatch->match_key = $data['match_key']; 
        $csmatch->score_1 = 0; 
        $csmatch->score_2 = 0; 
        $csmatch->status = 0;
        //пароль нельзя хранить в открытом виде, 
        //мы его шифруем при помощи функции password_hash для php > 5.6

        R::store($csmatch);

        echo '<div style="color:dreen;">Create successfully!</div><hr>';
    }else
    {
        //echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
    }
}
controller::init_view($route, "main", true, "header_main");
?>