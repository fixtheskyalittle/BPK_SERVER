<?php

R::setup( 'mysql:host=database-5.c7powqufdyap.eu-central-1.rds.amazonaws.com;dbname=server','fegion', 'password' );
session_start();
$https = false;


if ($https){
	$first_level = "https://";
}else{
	$first_level = "http://";
}

?>