<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';
require_once DVWA_WEB_PAGE_TO_ROOT . "external/recaptcha/recaptchalib.php";

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Feature: CAPTCHA' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'captcha';
$page[ 'help_button' ]   = 'captcha';
$page[ 'source_button' ] = 'captcha';

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

$hide_form = false;
require_once DVWA_WEB_PAGE_TO_ROOT . "features/captcha/source/{$featureFile}";

// Check if we have a reCAPTCHA key
$WarningHtml = '';
if( $_DVWA[ 'recaptcha_public_key' ] == "" ) {
	$WarningHtml = "<div class=\"warning\"><em>reCAPTCHA API key missing</em> from config file: " . realpath( getcwd() . DIRECTORY_SEPARATOR . DVWA_WEB_PAGE_TO_ROOT . "config" . DIRECTORY_SEPARATOR . "config.inc.php" ) . "</div>";
	$html = "<em>Please register for a key</em> from reCAPTCHA: " . dvwaExternalLinkUrlGet( 'https://www.google.com/recaptcha/admin/create' );
	$hide_form = true;
}

$page[ 'body' ] .= "
	<div class=\"body_padded\">
	<h1>Feature: CAPTCHA</h1>

	{$WarningHtml}

	<div class=\"code_area\">
		<form action=\"#\" method=\"POST\" ";

if( $hide_form )
	$page[ 'body' ] .= "style=\"display:none;\"";

$page[ 'body' ] .= ">
			<h3>Change your password:</h3>
			<br />

			<input type=\"hidden\" name=\"step\" value=\"1\" />\n";

if( $featureFile == 'v4.php' ) {
	$page[ 'body' ] .= "
			Current password:<br />
			<input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_current\"><br />";
}

$page[ 'body' ] .= "			New password:<br />
			<input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_new\"><br />
			Confirm new password:<br />
			<input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_conf\"><br />

			" . recaptcha_get_html( $_DVWA[ 'recaptcha_public_key' ] );
if( $featureFile == 'v3.php' )
	$page[ 'body' ] .= "\n\n			<!-- **DEV NOTE**   Response: 'hidd3n_valu3'   &&   User-Agent: 'reCAPTCHA'   **/DEV NOTE** -->\n";

if( $featureFile == 'v3.php' || $featureFile == 'v4.php' )
	$page[ 'body' ] .= "\n			" . tokenField();

$page[ 'body' ] .= "
			<br />

			<input type=\"submit\" value=\"Change\" name=\"Change\">
		</form>
		{$html}
	</div>

	<h2>More Information</h2>
	<ul>
		<li>" . dvwaExternalLinkUrlGet( 'https://en.wikipedia.org/wiki/CAPTCHA' ) . "</li>
		<li>" . dvwaExternalLinkUrlGet( 'https://www.google.com/recaptcha/' ) . "</li>
		<li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-project-automated-threats-to-web-applications/assets/oats/EN/OAT-009_CAPTCHA_Defeat' ) . "</li>
	</ul>
</div>\n";

dvwaHtmlEcho( $page );

?>
