<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: Change ID and View Changes' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'change_id_view';
$page[ 'help_button' ]   = 'change_id_view';
$page[ 'source_button' ] = 'change_id_view';

dvwaDatabaseConnect();

$method            = 'GET';
$featureFile = '';
switch( dvwaSecurityLevelGet() ) {
	case 'v1':
		$featureFile = 'v1.php';
		break;
	case 'v2':
		$featureFile = 'v2.php';
		$method = 'POST';
		break;
	case 'v3':
		$featureFile = 'v3.php';
		break;
	default:
		$featureFile = 'v4.php';
		break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "features/change_id_view/source/{$featureFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Feature: Change ID and View Changes</h1>

	<div class=\"code_area\">";
if( $featureFile == 'v3.php' ) {
	$page[ 'body' ] .= "Click <a href=\"#\" onclick=\"javascript:popUp('session-input.php');return false;\">here to change your ID</a>.";
}
else {
	$page[ 'body' ] .= "
		<form action=\"#\" method=\"{$method}\">
			<p>
				User ID:";
	if( $featureFile == 'medium.php' ) {
		$page[ 'body' ] .= "\n				<select name=\"id\">";

		for( $i = 1; $i < $number_of_rows + 1 ; $i++ ) { $page[ 'body' ] .= "<option value=\"{$i}\">{$i}</option>"; }
		$page[ 'body' ] .= "</select>";
	}
	else
		$page[ 'body' ] .= "\n				<input type=\"text\" size=\"15\" name=\"id\">";

	$page[ 'body' ] .= "\n				<input type=\"submit\" name=\"Submit\" value=\"Submit\">
			</p>\n";

	if( $featureFile == 'v4.php' )
		$page[ 'body' ] .= "			" . tokenField();

	$page[ 'body' ] .= "
		</form>";
}
$page[ 'body' ] .= "
		{$html}
	</div>

	<h2>More Information</h2>
</div>\n";

dvwaHtmlEcho( $page );

?>
