<?

include("ascii85.php");

function str_to_hex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= str_pad(dechex(ord($string[$i])), 2, '0', STR_PAD_LEFT);
    }
    return $hex;
}

function pdf_ASCIIHexEncode($string){
	return str_to_hex($string) . ">";
}
function pdf_FlateEncode($string){
	return gzcompress($string);
}
function pdf_ASCII85Encode($string){
	$ascii85 = new ASCII85();
	return $ascii85->encode($string);
}
function RandomNonASCIIString($count){
		$result = "";
		for($i = 0; $i < $count; $i++){
			$result  = $result . chr(rand(128, 255));
		}
		return $result;
}

function ioDef($id){
		return $id . " 0 obj\r\n";
}

function ioRef($id){
		return $id . " 0 R";
}


?>
