<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: Generate Session IDs' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'gen_sess_ids';
$page[ 'help_button' ]   = 'gen_sess_ids';
$page[ 'source_button' ] = 'gen_sess_ids';
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

require_once DVWA_WEB_PAGE_TO_ROOT . "features/gen_sess_ids/source/{$featureFile}";


$page[ 'body' ] .= <<<EOF
<div class="body_padded">
	<h1>Feature: Generate Session IDs</h1>
	<p>
		This page will set a new cookie called dvwaSession each time the button is clicked.<br />
	</p>
	<form method="post">
		<input type="submit" value="Generate" />
	</form>
</div>
$html

EOF;

/*
Maybe display this, don't think it is needed though
if (isset ($cookie_value)) {
	$page[ 'body' ] .= <<<EOF
	The new cookie value is $cookie_value
EOF;
}
*/

dvwaHtmlEcho( $page );

?>
