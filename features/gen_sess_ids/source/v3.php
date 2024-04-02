<?php

$html = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!isset ($_SESSION['last_session_id_high'])) {
		$_SESSION['last_session_id_high'] = 0;
	}
	$_SESSION['last_session_id_high']++;
	$cookie_value = md5($_SESSION['last_session_id_high']);
	setcookie("dvwaSession", $cookie_value, time()+3600, "/features/gen_sess_ids/", $_SERVER['HTTP_HOST'], false, false);
}

?>
