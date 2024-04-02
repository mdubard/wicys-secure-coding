<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: Login' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'login';
$page[ 'source_button' ] = 'login';
dvwaDatabaseConnect();

$method            = 'GET';
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
		$method = 'POST';
		break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "features/login/source/{$featureFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Feature: Login</h1>

	<div class=\"code_area\">
		<h2>Login</h2>

		<form action=\"#\" method=\"{$method}\">
			Username:<br />
			<input type=\"text\" name=\"username\"><br />
			Password:<br />
			<input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password\"><br />
			<br />
			<input type=\"submit\" value=\"Login\" name=\"Login\">\n";

if( $featureFile == 'v3.php' || $featureFile == 'v4.php' )
	$page[ 'body' ] .= "			" . tokenField();

$page[ 'body' ] .= "
		</form>
		{$html}
	</div>
</div>\n";

dvwaHtmlEcho( $page );

?>
