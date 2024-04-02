<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] .= 'Source' . $page[ 'title_separator' ].$page[ 'title' ];

if (array_key_exists ("id", $_GET) && array_key_exists ("security", $_GET)) {
	$id       = $_GET[ 'id' ];
	$security = $_GET[ 'security' ];


	switch ($id) {
		case "login" :
			$vuln = 'Login';
			break;
		case "ping" :
			$vuln = 'Ping any IP';
			break;
		case "change_id_view" :
			$vuln = 'Change ID and View Changes';
			break;
		case "change_id_blind" :
			$vuln = 'Change ID (Blind)';
			break;
		case "upload" :
			$vuln = 'File Upload';
			break;
		case "name_entry" :
			$vuln = 'Enter Name';
			break;
		case "sign_guestbook" :
			$vuln = 'Sign Guestbook';
			break;
		case "gen_sess_ids" :
			$vuln = 'Generate Session IDs';
			break;
		case "javascript" :
			$vuln = 'JavaScript';
			break;
		case "adminportal" :
			$vuln = 'Admin Portal';
			break;
		default:
			$vuln = "Unknown Feature";
	}

	$source = @file_get_contents( DVWA_WEB_PAGE_TO_ROOT . "features/{$id}/source/{$security}.php" );
	$source = str_replace( array( '$html .=' ), array( 'echo' ), $source );

	$js_html = "";
	if (file_exists (DVWA_WEB_PAGE_TO_ROOT . "features/{$id}/source/{$security}.js")) {
		$js_source = @file_get_contents( DVWA_WEB_PAGE_TO_ROOT . "features/{$id}/source/{$security}.js" );
		$js_html = "
		<h2>features/{$id}/source/{$security}.js</h2>
		<div id=\"code\">
			<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
				<tr>
					<td><div id=\"code\">" . highlight_string( $js_source, true ) . "</div></td>
				</tr>
			</table>
		</div>
		";
	}

	$page[ 'body' ] .= "
	<div class=\"body_padded\">
		<h1>{$vuln} Source</h1>

		<h2>features/{$id}/source/{$security}.php</h2>
		<div id=\"code\">
			<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
				<tr>
					<td><div id=\"code\">" . highlight_string( $source, true ) . "</div></td>
				</tr>
			</table>
		</div>
		{$js_html}
		<br /> <br />

		<form>
			<input type=\"button\" value=\"Compare All Levels\" onclick=\"window.location.href='view_source_all.php?id=$id'\">
		</form>
	</div>\n";
} else {
	$page['body'] = "<p>Not found</p>";
}

dvwaSourceHtmlEcho( $page );

?>
