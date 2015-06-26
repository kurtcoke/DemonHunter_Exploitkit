<?


include('../config.php');


session_start();
if(isset($_POST["user"]) && ($_POST["user"] == $panel_user) && isset($_POST["pass"]) && ($_POST["pass"] == $panel_pass) || ($_SESSION["login"] == true)){
	$_SESSION["login"] = true;
	header("Location: statistics.php");
	exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Log In</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css" />	
	</head>

<body>
	<div id="wrapper" class="clearfix">
		<div id="main-header">
			<div id="main-header-banner"></div>
		</div>
						
		<!-- NAVIGATION STARTS -->
		<div class="navigation">		
			<ul class="nav-links">        
				
				<li class="spacer">
				</li>
				<li class="spacer">
				</li>
				<li class="spacer">
				</li>				
				<li class="middlebar">
				</li>				
				<li class="spacer2">
				</li>
				<li class="spacer">
				</li>
				<li class="spacer">
				</li>
				<li class="spacer">
				</li>
				
			</ul>
		</div>
		<!-- NAVIGATION ENDS -->
						
		<!-- CONTENT STARTS -->
		<div id="main-body">
			
			<div id="main-body-login">
				<div class="login-box">
					<div class="login-box-title"><h4><b>Login</b></h4></div>
					<form method="post" action="login.php">
						<table>
							<tr>
								<td><b>User</b></td>
								<td><input type="text" name="user"></td>
							</tr>
							<tr>
								<td><b>Password</b></td>
								<td><input type="password" name="pass"></td>							
							</tr>
							<tr>
								<td></td>
								<td align="right"><input type="submit" value="Login"></td>
							</tr>
						</table>
					</form>
				</div>
			</div>			
		</div>
	</div>
</body>
</html>
