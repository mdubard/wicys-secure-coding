<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: Enter Name' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'name_entry';
$page[ 'help_button' ]   = 'name_entry';
$page[ 'source_button' ] = 'name_entry';

dvwaDatabaseConnect();

$featureFile = '';
switch( dvwaSecurityLevelGet() ) {
	case 'v1':
		$featureFile = 'v1.php';
		break;
	case 'v2':
		$featureFile = 'v2.php';
		break;
	case 'v3':
		$featureFile = 'v3.php';
		break;
	default:
		$featureFile = 'v4.php';
		break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "features/name_entry/source/{$featureFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Feature: Enter Name</h1>

	<div class=\"code_area\">
		<form name=\"Name\" action=\"#\" method=\"GET\">
			<p>
				What's your name?
				<input type=\"text\" name=\"name\">
				<input type=\"submit\" value=\"Submit\">
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
