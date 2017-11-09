<?php
function replace_accented_chars($str){
	$ekezetek =       array('á', 'é', 'í', 'ó', 'ö', 'ő', 'ú', 'ü', 'ű', 'Á', 'É', 'Í', 'Ó', 'Ö', 'Ő', 'Ú', 'Ü', 'Ű', ' ');
	$ekezetmentesek = array('a', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U', '_');
	$str = str_replace($ekezetek, $ekezetmentesek, $str);
	return $str;
}

function sign( $number ) { 
    return ( $number > 0 ) ? 1 : ( ( $number < 0 ) ? -1 : 0 ); 
}

function renderScript( $str ){
// leválogatja a PHP scripteket, sorban futtatja a PHP-t és echo-zza a HTML-t
	$PHP = ''; $HTML = ''; $script = array();
	$pos = 0; $startHTML = 0; $endHTML = 0; $startPHP = 0; $endPHP = 0;
	while( $pos < strlen($str) ){
		$startHTML = $pos;
		$startPHP = strpos( $str, "<?php", $pos );
		if ($startPHP===false) $endHTML = strlen($str);
		else $endHTML = $startPHP;
		$HTML = substr($str, $startHTML, $endHTML - $startHTML);
		echo $HTML;
		
		if ($startPHP === false) break;
		
		$endPHP = strpos( $str, '?>', $pos );
		$PHP = substr( $str, ($startPHP+5), $endPHP - ($startPHP+5) );
		eval($PHP);
		
		$pos = $endPHP + 2;
	}
/* EXAPLE
	$str = '
		<h2>html1</h2>
		<?php echo "<h1>siker</h1>"; ?>
		<h2>html2</h2>
		<h2>html3</h2>
		<?php echo "<h1>siker2</h1>"; ?>
	';
	renderScript( $str );
*/
}

function valid_email($email)
	{
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   if (is_bool($atIndex) && !$atIndex)
	   {
	      $isValid = false;
	   }
	   else
	   {
	      $domain = substr($email, $atIndex+1);
	      $local = substr($email, 0, $atIndex);
	      $localLen = strlen($local);
	      $domainLen = strlen($domain);
	      if ($localLen < 1 || $localLen > 64)
	      {
		 // local part length exceeded
		 $isValid = false;
	      }
	      else if ($domainLen < 1 || $domainLen > 255)
	      {
		 // domain part length exceeded
		 $isValid = false;
	      }
	      else if ($local[0] == '.' || $local[$localLen-1] == '.')
	      {
		 // local part starts or ends with '.'
		 $isValid = false;
	      }
	      else if (preg_match('/\\.\\./', $local))
	      {
		 // local part has two consecutive dots
		 $isValid = false;
	      }
	      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
	      {
		 // character not valid in domain part
		 $isValid = false;
	      }
	      else if (preg_match('/\\.\\./', $domain))
	      {
		 // domain part has two consecutive dots
		 $isValid = false;
	      }
	      else if
			(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
			 str_replace("\\\\","",$local)))
	      {
		 // character not valid in local part unless 
		 // local part is quoted
		 if (!preg_match('/^"(\\\\"|[^"])+"$/',
		     str_replace("\\\\","",$local)))
		 {
		    $isValid = false;
		 }
	      }
	      if ($isValid && !(checkdnsrr($domain,"MX") || 
		checkdnsrr($domain,"A")))
	      {
		 // domain not found in DNS
		 $isValid = false;
	      }
	   }
	   return $isValid;
	}
?>