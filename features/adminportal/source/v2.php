<?php
/*

Only the admin user is allowed to access this page.

Have a look at these two files for possible vulnerabilities: 

* features/adminportal/get_user_data.php
* features/adminportal/change_user_details.php

*/

if (dvwaCurrentUser() != "admin") {
	print "Unauthorised";
	http_response_code(403);
	exit;
}
?>
