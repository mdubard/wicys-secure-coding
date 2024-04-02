<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: File Upload' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'upload';
$page[ 'help_button' ]   = 'upload';
$page[ 'source_button' ] = 'upload';

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

require_once DVWA_WEB_PAGE_TO_ROOT . "features/upload/source/{$featureFile}";

// Check if folder is writeable
$WarningHtml = '';
if( !is_writable( $PHPUploadPath ) ) {
	$WarningHtml .= "<div class=\"warning\">Incorrect folder permissions: {$PHPUploadPath}<br /><em>Folder is not writable.</em></div>";
}
// Is PHP-GD installed?
if( ( !extension_loaded( 'gd' ) || !function_exists( 'gd_info' ) ) ) {
	$WarningHtml .= "<div class=\"warning\">The PHP module <em>GD is not installed</em>.</div>";
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Feature: File Upload</h1>

	{$WarningHtml}

	<div class=\"code_area\">
		<form enctype=\"multipart/form-data\" action=\"#\" method=\"POST\">
			<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000\" />
			Choose an image to upload:<br /><br />
			<input name=\"uploaded\" type=\"file\" /><br />
			<br />
			<input type=\"submit\" name=\"Upload\" value=\"Upload\" />\n";

if( $featureFile == 'v4.php' )
	$page[ 'body' ] .= "			" . tokenField();

$page[ 'body' ] .= "
		</form>
		{$html}
	</div>

</div>";

dvwaHtmlEcho( $page );

?>
