<?php


    $jsonpSingleTime = getMillisecond();

    $jsonpSingleNextTime = getMillisecond() + 1;

    echo "$jsonpSingleTime"."<br>";

    return;

    $user_agent = "Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/600.1.4";

	$proxyip = "166.111.134.46";
	$proxyport = "3128";

	$proxyAddr = $proxyip.":".$proxyport;

	$content = " ";
   

    $tempReference = "http://m.dgmaoshun.com/airticle/4879.html?aid=4879&uid=228812&from=timeline&isappinstalled=0";

	$content = curl_get_task_string("http://m.bjhhsg.com/checkpvf.php?callback=jQuery110202761367929633707_$jsonpSingleTime&aid=4879&uid=228812&_=$jsonpSingleNextTime",$proxyAddr,$user_agent,$tempReference,$proxyip,$proxyip.".cookie_wz");

	echo "$content"."<br>";

	//获取毫秒
	function getMillisecond() {

		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
	}

	function curl_get_task_string ($url,$proxyAddr,$user_agent,$referer,$cheatip,$cookieFile){
		$ch = curl_init();
		echo "<br>";

		echo $url."<br>".$proxyAddr."<br>".$user_agent."<br>".$referer."<br>".$cheatip."<br>";

		curl_setopt ($ch, CURLOPT_URL, $url);

		// // 抓包 start
		// curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		// curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// // 抓包 end

		// curl_setopt($ch, CURLOPT_PROXY, $proxyAddr);

		// $cookie_jar = dirname(__FILE__)."/cookies/$cookieFile";
		
		// curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		// curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);

		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Referer:$referer", "CLIENT-IP:$cheatip", "X-FORWARDED-FOR:$cheatip"));  //此处可以改为任意假IP
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);

		curl_exec ($ch);

		$result = curl_multi_getcontent($ch);

		curl_close($ch);
		return $result;
	}

?>