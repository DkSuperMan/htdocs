<?php

function getClientIp() { 
	echo "<br>";
if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
	$ip = $_SERVER["HTTP_CLIENT_IP"]; 

	echo "HTTP_CLIENT_IP is $ip";
	echo "<br>";
}

 if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
	echo "HTTP_X_FORWARDED_FOR is $ip";
	echo "<br>";
}

 if (!empty($_SERVER["REMOTE_ADDR"])) {
	$ip = $_SERVER["REMOTE_ADDR"]; 
	echo "REMOTE_ADDR is $ip";
	echo "<br>";
}

echo "<br>";
return $ip; 
} 
echo "<br>";
echo "IP: " . getClientIp() . ""; 
echo "<br>";
echo "referer: " . $_SERVER["HTTP_REFERER"]; 
echo "<br>";
?>