<?php 
$title = "vBote - My Token";
$account_info = R::findOne("users", "id = ?", [$_SESSION['auth_perx']->id]);
controller::init_view($route, "token", false, null);
?>
