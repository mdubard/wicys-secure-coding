<?php

$html = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$cookie_value = sha1(mt_rand() . time() . "Impossible");
	setcookie("dvwaSession", $cookie_value, time()+3600, "/features/gen_sess_ids/", $_SERVER['HTTP_HOST'], true, true);
}
?>
