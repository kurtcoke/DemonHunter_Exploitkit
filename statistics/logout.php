<?

session_start();
$_SESSION["login"] = false;
header("Location: login.php");
exit();
?>
