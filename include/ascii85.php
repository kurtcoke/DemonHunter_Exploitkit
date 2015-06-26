<?php


/**
 * Adapted from the work of Paul Haahr, http://www.webcom.com/~haahr/
 *   http://www.stillhq.com/cgi-bin/cvsweb/ascii85/
 * 
*/
/** 
 * @package ASCII85 
 * @example  /ascii85example.php  Example usage of this class.
 * @category   Numbers
 * @author Sam Shull <samshull@samshull.com>
 * @copyright Copyright (c) 2007, Sam Shull
 * @license http://www.samshull.com/bsdlicense.txt BSD License
 * @link       http://samshull.com/ascii85example.php
 * @version    0.9
 * @access     public
*/
class ASCII85{
/**
 * Line width for splitting
 *
 * @var integer
 * @access protected
 */
 var $width = 72;
/**
 * Position within the line
 *
 * @var integer
 * @access protected
 */
 var $pos = 0;
/**
 * Unsigned long being manipulated
 *
 * @var string
 * @access protected
 */
 var $tuple = "0";
/**
 * Number of bytes being manipulated
 *
 * @var integer
 * @access protected
 */
 var $count = 0;
/**
 * Output
 *
 * @var string
 * @access protected
 */
 var $out = "";
/**
 * Power of 85 multiplier
 *
 * @var array
 * @access protected
 */
 var $pow85;
/**
 * Error
 *
 * @var string
 * @access public
 */
 var $error;
/**
 * For storing unpacked bytes
 *
 * @var array
 * @access protected
 */
 var $array = array();
/**
 * Position within byte array
 *
 * @var integer
 * @access protected
 */
 var $i = 1;

/**
 * Method: encode  
 *   Primary encoding method, one argument, the string that is to be encoded
 * @param string $string
 * @return string
**/
function encode($string){
   $this->error = "";
   $this->out = "";
	$this->pos = 2;
	
	  $array = unpack("C*",$string);
	  //print_r($array);
	  for($i=1;$i<=count($array);$i++){
		$this->put85($array[$i]);
	  }
	  
   if ($this->count > 0)
		$this->encode85(false);
	if ($this->pos + 2 > $this->width)
		$this->out.="\n";
	$this->out.="~>\n";
	  if($this->error){
	    return $this->error;
	  }else{
	    return $this->out;
	  }
}

/**
 * Method: encode85  - if PHP5 mark as private or protected
 *     Method used to convert an unsigned long to ASCII characters
 *      One parameter bool increase the count by one when adding 
 *        encoded characters to output string
 * @param bool $tru default:true
**/
function encode85($tru=true) {
	$s = array();
	$i = 5;
	 while (--$i >= 0){
		$s[$i] = (int)bcmod($this->tuple,"85");
		$this->tuple = bcdiv($this->tuple,"85");
	}
	//print_r($s);
	$f = $tru ? 1 : 0;
	 for($i=0;$i<=$this->count+$f;$i++){
		$this->out .= chr(($s[$i] + ord('!')));
		if ($this->pos++ >= $this->width) {
			$this->pos = 0;
			$this->out.="\n";
		}
	}
}
/**
 * Method: put85  - if PHP5 mark as private or protected
 *    Method is passed each char of the string to be encoded and adds it
 *     to an unsigned long for conversion by encode85
 * @param decimal $c
**/
function put85($c) {
	switch ($this->count) {
	case 0:	$this->tuple = bcadd($this->lshift($c,24),$this->tuple); 
			$this->count++; 
			break;
	case 1: $this->tuple = bcadd($this->tuple,((string)($c << 16))); 
			 $this->count++; 
			 break;
	case 2:	$this->tuple = bcadd($this->tuple,((string)($c << 8))); 
			$this->count++; 
			break;
	case 3:
		$this->tuple = bcadd($this->tuple,((string)$c));
		if ($this->tuple == 0) {
			$this->out.='z';
			if ($this->pos++ >= $this->width) {
				$this->pos = 0;
				$this->out.="\n";
			}
		} else {
			$this->encode85();
		}
		$this->tuple = "0";
		$this->count = 0;
		break;
	}
}
/**
 * Method: decode
 *   Primary method used to decode an encoded string, one parameter an encoded string
 *     Breaks apart string for encoding and returns
 * @param string $string
 * @return string
**/
  function decode($string){
      $this->error = "";
	  $this->out = "";
	  $this->count = 0;
      $this->pow85 = array((85*85*85*85), (85*85*85), (85*85), 85, 1);
	  $string=preg_replace("/^<~/isx","",$string);
	  $this->array = str_split($string);
	  while($this->i < count($this->array)){
		$this->decode85(current($this->array));
		next($this->array);
		$this->i++;
	  }
	  if($this->error){
	    return $this->error;
	  }else{
	    return $this->out;
	  }
  }
/**
 *  Method: wput - if PHP5 mark as private or protected
 *     Used to pack the output codes, one parameter number of bytes to output
 * @param int $bytes
**/
  function wput($bytes) {
	switch ($bytes) {
	case 4:
		$this->out.=pack("C",$this->rshift($this->tuple,24));
		$this->out.=pack("C",$this->rshift($this->tuple,16));
		$this->out.=pack("C",$this->rshift($this->tuple,8));
		$this->out.=pack("C",((float)$this->tuple));
		break;
	case 3:
		$this->out.=pack("C",$this->rshift($this->tuple,24));
		$this->out.=pack("C",$this->rshift($this->tuple,16));
		$this->out.=pack("C",$this->rshift($this->tuple,8));
		break;
	case 2:
		$this->out.=pack("C",$this->rshift($this->tuple,24));
		$this->out.=pack("C",$this->rshift($this->tuple,16));
		break;
	case 1:
		$this->out.=pack("C",$this->rshift($this->tuple,24));
		break;
	}
	//$this->tuple = "0";
  }
/**
 * Method: decode85 - if PHP5 mark as private or protected
 *   Used to decode the chars and add them up in an unsigned long
 *     to be encoded, one paramater char to be added
 * @param char $c
**/
  function decode85($c) {
	switch ($c) {
		case 'z':
			if ($this->count != 0) {
				$this->error.="\n: z inside ascii85 5-tuple";
				return;
			}
			$this->out.=pack("C",0x00);
			$this->out.=pack("C",0x00);
			$this->out.=pack("C",0x00);
			$this->out.=pack("C",0x00);
			break;
		case '~':
			$c = next($this->array);
			if ($c == '>') {
				if ($this->count > 0) {
					$this->count--;
					$this->tuple = bcadd($this->tuple,$this->pow85[$this->count]);
					$this->wput($this->count);
				}
				return;
			}
			$this->error.="\n: ~ without > in ascii85 section";
			return;
		case "\n": case "\r": case "\t": case " ":
		case "\0": case "\f": case "\b": case 0177:
			break;
		default:
		    //echo (ord($c)-ord('!'))."\n";
			if (ord($c) < ord('!') || ord($c) > ord('u')) {
				$this->error.="\nBad character in ascii85 region: ".current($this->array)." ".$this->i;
				//return;
			}
			$this->tuple = bcadd($this->tuple,bcmul((ord($c)-ord('!')),$this->pow85[$this->count]));
			$this->count++;
			if ($this->count == 5) {
				$this->wput(4);
				$this->count = 0;
				$this->tuple = "0";
			}
			break;
		}
  }
/**
 * Method: lshift - if PHP5 mark as private or protected
 *   Used to allow class to deal with unsigned longs, bitwise left shift
 *    Two parameters, number to be shifted, and how much to shift
 * @param int|string $n
 * @param int $b
 * @return string
**/
  function lshift($n,$b){
   for($t=0;$t<$b;$t++){
      $n = bcmul($n,"2");
   }
   return ((string)$n);
  }
/**
 * Method: rshift - if PHP5 mark as private or protected
 *   Used to allow class to deal with unsigned longs, bitwise right shift
 *    Two parameters, number to be shifted, and how much to shift
 * @param int $n
 * @param int $b
 * @return int
 */
  function rshift($n,$b){
   for($t=0;$t<$b;$t++){
      $n = bcdiv($n,"2");
   }
   return ((int)$n);
  }
}

?>
