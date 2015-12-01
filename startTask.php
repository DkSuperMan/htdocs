<?php 

	echo "开始任务";
	echo "<br>";
	error_reporting(0);

	function curl_string ($url,$user_agent,$proxy){
	$ch = curl_init();
	// curl_setopt ($ch, CURLOPT_PROXY, $proxy);
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt ($ch, CURLOPT_HEADER, 1);
	curl_setopt ($ch, CURLOPT_HTTPHEADER, array('CLIENT-IP:255.255.255.255', 'X-FORWARDED-FOR:255.255.255.255'));  //此处可以改为任意假IP
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);

	$result = curl_exec ($ch);
	curl_close($ch);
	return $result;
	}
	$url_page = "http://localhost/getip.php";
	$user_agent = "Mozilla/4.0";
	// $proxy = "http://115.148.25.187:9000";    //此处为代理服务器IP和PORT高级匿名代理
	$string = curl_string($url_page,$user_agent,$proxy);

	echo $string;

	echo "<br>";
	echo "结束任务";
	echo "<br>";
?>


<!-- error_reporting(0);

function curl_string ($url,$user_agent,$proxy){
$ch = curl_init();
curl_setopt ($ch, CURLOPT_PROXY, $proxy);
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt ($ch, CURLOPT_COOKIEJAR, "d:\cookies.txt");
curl_setopt ($ch, CURLOPT_HEADER, 1);
curl_setopt ($ch, CURLOPT_HTTPHEADER, array('CLIENT-IP:125.210.188.36', 'X-FORWARDED-FOR:125.210.188.36'));  //此处可以改为任意假IP
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_TIMEOUT, 120);

$result = curl_exec ($ch);
curl_close($ch);
return $result;
}
$url_page = "http://localhost/getip.php";
$user_agent = "Mozilla/4.0";
$proxy = "http://125.210.188.36:80";    //此处为代理服务器IP和PORT

$string = curl_string($url_page,$user_agent,$proxy);

echo $string; -->



	<!-- $ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "http://localhost/getip.php"); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:8.8.8.8')); //构造IP 
	curl_setopt($ch, CURLOPT_REFERER, "http://www.jb51.net/ "); //构造来路 
	curl_setopt($ch, CURLOPT_HEADER, 1); 
	$out = curl_exec($ch); 
	curl_close($ch); 
 -->