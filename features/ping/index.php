<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: Ping any IP' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'ping';
$page[ 'help_button' ]   = 'ping';
$page[ 'source_button' ] = 'ping';

dvwaDatabaseConnect();

$featureFile = '';
switch( dvwaSecurityLevelGet() ) {
	case 'low':
		$featureFile = 'v1.php';
		break;
	case 'medium':
		$featureFile = 'v2.php';
		break;
	case 'high':
		$featureFile = 'v3.php';
		break;
	default:
		$featureFile = 'v4.php';
		break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "features/ping/source/{$featureFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Feature: Ping any IP</h1>

	<div class=\"code_area\">
		<h2>Ping a device</h2>

		<form name=\"ping\" action=\"#\" method=\"post\">
			<p>
				Enter an IP address:
				<input type=\"text\" name=\"ip\" size=\"30\">
				<input type=\"submit\" name=\"Submit\" value=\"Submit\">
			</p>\n";

if( $featureFile == 'v4.php' )
	$page[ 'body' ] .= "			" . tokenField();

$page[ 'body' ] .= "
		</form>
		{$html}
	</div>


</div>\n";

dvwaHtmlEcho( $page );

?>
