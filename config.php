<?



//dbHost:  The hostname to where your MySQL database is located.
$sqlSettings['dbHost'] = 'localhost';

//dbUsername:  The username for your MySQL database.
$sqlSettings['dbUsername'] = 'admin';

//dbPassword:  The password for your MySQL database.
$sqlSettings['dbPassword'] = '123455';

//dbName:  The name your MySQL database.
$sqlSettings['dbName'] = '1234_2311base';

//tableVisitorsList:  The table name to track visitors.  This is created in the install process.
$sqlSettings['tableVisitorsList'] = 'visitors_list';

//panel_user: the username used to secure the statistics page
$panel_user = "admin";
//panel_pass: the password used to secure the statistics page
$panel_pass = "mypassword";


//enabled_signed: enable the java signed applet.  (this requires user interaction)
$enable_signed = true;


//exploit_delay: this is the delay between exploits in milliseconds.  10 seconds = 10000, 5 seconds = 5000, etc.
$exploit_delay = 5000;

//reuse_iframe:  by default each exploit is created in its own iframe.  set this to true to reuse the same iframe for each exploit
$reuse_iframe = false;

//ajax_stats:  refresh the "Overall Statistics" using ajax.
$ajax_stats = true;

//ajax_delay: this is the delay between refreshing in milliseconds.  10 seconds = 10000, 5 seconds = 5000, etc.
$ajax_delay = 5000;

?>
