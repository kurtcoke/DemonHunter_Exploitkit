<?


session_start();
if(($_SESSION["login"] == true)){
	header("Location: statistics.php");
	exit();
}else{
	header("Location: login.php");
	exit();	
}
?>
