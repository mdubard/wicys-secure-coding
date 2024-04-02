<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: Admin Portal' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'adminportal';
$page[ 'help_button' ]   = 'adminportal';
$page[ 'source_button' ] = 'adminportal';
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

require_once DVWA_WEB_PAGE_TO_ROOT . "features/adminportal/source/{$featureFile}";

$page[ 'body' ] .= '
<div class="body_padded">
	<h1>Feature: Admin Portal</h1>

	<p>This page should only be accessible by the admin user. Your challenge is to gain access to the features using one of the other users, for example <i>gordonb</i> / <i>abc123</i>.</p>

	<div class="code_area">
	<div style="font-weight: bold;color: red;font-size: 120%;" id="save_result"></div>
	<div id="user_form"></div>
	<p>
		Welcome to the user manager, please enjoy updating your user\'s details.
	</p>
	';

$page[ 'body' ] .= "
<script src='adminportal.js'></script>

<table id='user_table'>
	<thead>
		<th>ID</th>
		<th>First Name</th>
		<th>Surname</th>
		<th>Update</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
	populate_form();
</script>
";

$page[ 'body' ] .= '
		' . 
		$html
		. '
	</div>
</div>';

dvwaHtmlEcho( $page );

?>
