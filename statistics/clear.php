<?


include('../config.php');
include('../include/sql.php');
include('../include/visitors.php');

session_start();
if(($_SESSION["login"] == false)){
	header("Location: login.php");
	exit();	
}

$sql = new CSQL($sqlSettings);
$sql->open();
$cvisitors = new CVisitors($sql, $sqlSettings);
$cvisitors->clearVisitors();
header("Location: statistics.php");
exit();

?>
