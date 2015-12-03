<?php 
	
	require_once("redirectUrl.php");

	echo "开始测试";
	echo "<br>";
	error_reporting(0);
	$allTaskArray = array();


	$mobileArray = array("223.104.4.","117.136.0.","117.136.1.","218.204.177.","117.131.19.","211.140.0.");

	$wifiArray = array("218.94.121.","114.240.0.","221.239.16.","220.198.192.","202.96.224.","218.75.35.");


	$userAgentArray = array("Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12H143 MicroMessenger/6.3.7 NetType/WIFI Language/zh_CN",
		"Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12H143 MicroMessenger/6.3.7 NetType/3G+ Language/zh_CN",
		"Mozilla/5.0 (iPad; CPU OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F69 MicroMessenger/6.3.5 NetType/WIFI Language/zh_CN",
		"Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; SAMSUNG Build/KTU86P) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
		"Mozilla/5.0 (Linux; U; Android 4.4.2; zh-CN; SAMSUNG Build/KTU84P) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.1.0.527 U3/0.8.0 Mobile Safari/534.30",
		"Mozilla/5.0 (Linux; U; Android 5.0; zh-cn; GT-S5660 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MicroMessenger/4.5.255",
		"Mozilla/5.0 (Linux; U; Android 4.2.2; zh-cn; 2015011 Build/HM2014011) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 MicroMessenger/6.0.0.50_r844973.501 NetType/3G+",
		"Mozilla/5.0 (Linux; U; Android 5.1; zh-cn; 2014011 Build/HM2014011) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 MicroMessenger/6.0.0.50_r844973.501 NetType/WIFI",
		"Mozilla/5.0 (iPhone; CPU OS 9_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F69 MicroMessenger/6.3.5 NetType/3G+ Language/zh_CN",
		"Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F69 MicroMessenger/6.3.5 NetType/WIFI Language/zh_CN",
		"Mozilla/5.0 (iPad; CPU OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F69 MicroMessenger/6.3.5 NetType/WIFI Language/zh_CN");

	

	// $myColumnArr = getTaskColumnId();

	// $taskUrlArr = getAllTask($myColumnArr);

	// saveTaskToDB($taskUrlArr);



	$willStartTaskArr = getNotCompleteTask();
	// printf($willStartTaskArr);

	create_taskip_table();
	startTask($willStartTaskArr);

	// $url = 'http://www.artcm.cn/customer/login/';

	// $password = "I2brxrF\/FFvKsNr+JnMAoKhyxYZSHWp5P2B8kmzWvZZBM6M3NzVEe997pamXfozLTxExFq80xeLtb++uj6+THg8mhEiiTO+7EBCCsM+V1NsFBjYuck1tAbB20ypO8L1K9Mw70Ey8QRA9n2v9YqY2MBOx1Rn5yv+zOhSFnSiP3eg=";

	// $user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";
	// $test_post_data = array('username' => '13814057793', 'password' => $password);

	// test_Cookie($url,$test_post_data,$user_agent);

	



	function get_task_ip_Array(){

		$taskIpArray = array();

		Global $mobileArray,$wifiArray;

		for ($i=0; $i < count($mobileArray); $i++) {

			$tempArray = getRandIp($mobileArray[$i],50);

			for ($j=0; $j < count($tempArray); $j++) {
				
				$taskIpArray[] = $tempArray[$j];
			}

		}


		for ($i=0; $i < count($wifiArray); $i++) {

			$tempArray = getRandIp($wifiArray[$i],50);

			for ($j=0; $j < count($tempArray); $j++) {
				
				$taskIpArray[] = $tempArray[$j];
			}

		}

		// var_dump($taskIpArray);
		return $taskIpArray;
	}

	function create_taskip_table(){

		$con = mysql_connect("localhost","root","");
		if (!$con){
		  die('Could not connect: ' . mysql_error());
		}

		mysql_query("CREATE DATABASE wzTaskUrl_db",$con);

		mysql_select_db("wzTaskUrl_db", $con);
		$sql = "CREATE TABLE wzTaskip_Tab 
		(
		TaskIp varchar(50),
		IpCookieAid varchar(255),
		)";
		mysql_query($sql,$con);
		
		mysql_close($con);

	}

	function query_taskip_cookie($ipAddr){

		$con = mysql_connect("localhost","root","");
		if (!$con){
		  die('Could not connect: ' . mysql_error());
		}

		mysql_select_db("wzTaskUrl_db", $con);

		$result = mysql_query("SELECT * FROM wzTaskip_Tab WHERE TaskIp = $ipAddr");

		echo "<br>";

		mysql_close($con);

		if(mysql_num_rows($result))
		{
			return true;
		}
		return false;
		
	}

	function test_Cookie($url,$test_post_data,$user_agent){

		$ch = curl_init();
		echo "<br>";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, stripslashes(json_encode($test_post_data))); 

		// 抓包 start
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// 抓包 end

		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		$cookie_jar = dirname(__FILE__)."/cookies/pic.cookie";
		echo "$cookie_jar";
		echo "<br>";
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Client-Agent:device:iPhone;os:iOS8.4;version:1.0.0'));  //此处可以改为任意假IP
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);

		curl_exec ($ch);

		$result = curl_multi_getcontent($ch);

		printf($result);

		curl_close($ch);

	}

	echo "<br>";
	echo "结束测试";
	echo "<br>";

	function curl_post_string ($url,$user_agent,$post_data,$cheatip){

		$ch = curl_init();
		echo "<br>";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data)); 

		// 抓包 start
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// 抓包 end

		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		// $cookie_file = tempnam('./temp','cookie'); 
		// curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		// curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		// curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'application/json; charset=utf-8', "CLIENT-IP:$cheatip", "X-FORWARDED-FOR:$cheatip"));  //此处可以改为任意假IP
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);

		curl_exec ($ch);

		$result = curl_multi_getcontent($ch);

		curl_close($ch);
		return $result;
	}

	function curl_getHtml_string ($url,$user_agent,$cheatip,$cookieFile){

		$ch = curl_init();
		print_r($cheatip);

		echo "<br>";

		curl_setopt ($ch, CURLOPT_URL, $url);

		// 抓包 start
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// 抓包 end


		$cookie_jar = dirname(__FILE__)."/cookies/$cookieFile";
		
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);

		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);

		curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', "CLIENT-IP:$cheatip", "X-FORWARDED-FOR:$cheatip"));  //此处可以改为任意假IP
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);

		curl_exec ($ch);

		$result = curl_multi_getcontent($ch);

		curl_close($ch);
		return $result;
	}

	function curl_get_task_string ($url,$user_agent,$referer,$cheatip,$cookieFile){

		echo "$cookieFile"."<br>";

		$ch = curl_init();
		echo "<br>";

		curl_setopt ($ch, CURLOPT_URL, $url);

		// 抓包 start
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// 抓包 end

		$cookie_jar = dirname(__FILE__)."/cookies/$cookieFile";
		
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);

		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Referer:$referer", "CLIENT-IP:$cheatip", "X-FORWARDED-FOR:$cheatip"));  //此处可以改为任意假IP
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);

		curl_exec ($ch);

		$result = curl_multi_getcontent($ch);

		curl_close($ch);
		return $result;
	}

	function getIpData ($ipType){

		$con = mysql_connect("localhost","root","");
		if (!$con)
	  	{
	  		echo "connect database error $con";
	  	}

		mysql_select_db("task", $con);


		mysql_query("INSERT INTO taskip (ip1) VALUES ('1233')");

		mysql_query("INSERT INTO taskip (ip1) VALUES ('1234')");

		mysql_query("INSERT INTO taskip (ip1) VALUES ('1235')");

		mysql_close($con);
	}


	function getRandIp ($ipAddr,$num){

		//range 是将1到100 列成一个数组 
		$numbers = range (0,255); 
		//shuffle 将数组顺序随即打乱 
		shuffle ($numbers); 
		//array_slice 取该数组中的某一段 
		$result = array_slice($numbers,0,$num);

		$ipAddrArray = array();
		for ($i=0;$i<$num;$i++){

			$ipAddrArray[] = $ipAddr.$result[$i];
		} 

		return $ipAddrArray;
	}

	function getTaskColumnId()
	{

		$post_data = array ('token' => '754971d1eec66bb38176d8c4cedbacd9','uid' => '16772838','page_end' => '10','page_sta' => '1');

		$user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";

		$url_page = "http://zhuan.9766.com/index/neice.php?c=weizhuan&m=api&a=articles_ios";

		$jsonContent = curl_post_string($url_page,$user_agent,$post_data,"223.104.4.121");

		$content = json_decode($jsonContent);
		
		$allColumnArray = array_merge($content->column, $content->columnall); 

		print_r($allColumnArray);

		return $allColumnArray;
	}

	function getAllTask($columnArray)
	{
		echo "<br>";
		
		foreach ($columnArray as $valueId) {

			$cidId =  $valueId->cid;

			//每种类型获取多少分页
			for($i = 1;$i < 2;$i++){

				$post_data = array ('token' => '754971d1eec66bb38176d8c4cedbacd9','uid' => '16772838','cid' => $cidId,'page_end' => '10','page_sta' => $i);

				// print_r($post_data);

				$user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";

				$url_page = "http://zhuan.9766.com/index/neice.php?c=weizhuan&m=api&a=articles_ios";

				$jsonContent = curl_post_string($url_page,$user_agent,$post_data,"223.104.4.121");

				$content = json_decode($jsonContent);

				$arrContent = $content->arcRows;

				foreach ($arrContent as $singleContent) {

					$item=array("aid"=>$singleContent->aid,"url"=>"$singleContent->url&uid=16772838&from=singlemessage&isappinstalled=1");
					$allTaskArray[] = $item;
				}

				
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "sleep start";

				sleep(1);

				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "sleep end";

				
			}

			break;

		}

		return $allTaskArray;
	}

	function saveTaskToDB($taskUrlArray)
	{
		$con = mysql_connect("localhost","root","");
		if (!$con){
		  die('Could not connect: ' . mysql_error());
		}

		mysql_query("CREATE DATABASE wzTaskUrl_db",$con);

		mysql_select_db("wzTaskUrl_db", $con);
		$sql = "CREATE TABLE wzTaskUrl_Tab 
		(
		Aid varchar(50),
		Taskurl varchar(255),
		ClickNum int
		)";
		mysql_query($sql,$con);

		// print_r($taskUrlArray);

		foreach ($taskUrlArray as $urlValue) {

			$itemUrl = $urlValue['url'];
			$itemAid = $urlValue['aid'];
			
			$result = mysql_query("SELECT * FROM wzTaskUrl_Tab WHERE Aid='$itemAid'");
			// echo "<br>";
			// print_r($result);
			// echo "<br>";
			// $row = mysql_fetch_array($result, MYSQL_ASSOC);
			// print_r($row);
			// echo "<br>";

		    if (!mysql_num_rows($result))  
		        {  
		            mysql_query("INSERT INTO wzTaskUrl_Tab (Aid, Taskurl, ClickNum) VALUES ('$itemAid','$itemUrl','0')");
		        }
		}
		
		mysql_close($con);
	}

	function getNotCompleteTask()
	{
		$con = mysql_connect("localhost","root","");
		if (!$con){
		  die('Could not connect: ' . mysql_error());
		}

		mysql_select_db("wzTaskUrl_db", $con);

		$result = mysql_query("SELECT * FROM wzTaskUrl_Tab WHERE ClickNum < 100");

		echo "<br>";

		print_r(mysql_num_rows($result));

		$notCompleteTaskArray = array();

		while($row = mysql_fetch_array($result))
		  {

		  	$notCompleteTaskArray[] = $row;
		  }
		  
		  mysql_close($con);
		  return $notCompleteTaskArray;
	}

	function startTask($taskArr)
	{


		//从未完成的任务中抽取6个准备开始做任务
		shuffle ($taskArr); 
		$result = array_slice($taskArr,0,1);
		echo "<br>";

		$tempArray = array();

		for ($i=0;$i<1;$i++){

			$item =  $result[$i];

			$tempArray[] = $item;
			echo $item['Taskurl']."<br>";
		}

		$taskipArray =  get_task_ip_Array();

		Global $userAgentArray;

		// for ($i=0; $i < count($taskipArray); $i++) { 
			
		for ($i=0; $i < 5; $i++) {

			shuffle ($userAgentArray); 
			$randUserAgent = array_slice($userAgentArray,0,1);

			// echo $result."<br>";

			// var_dump($result);

			// print_r($);

			echo "<br>";




			$tempurl =  $tempArray[$i]['Taskurl'];
			$aid =  $tempArray[$i]['Aid'];
			$user_agent = $randUserAgent[0];
			$jsonpTime = 'jsonp'. getMillisecond();

			$tempTaskIP = $taskipArray[$i];

			echo "$tempTaskIP"."<br>";

			// $tempTaskIP = "223.104.4.227";
			//每个ip就一个cookie

			//get原始页面
			$htmlContent = curl_getHtml_string($tempurl,$user_agent,$tempTaskIP,$tempTaskIP.".".md5($tempurl));

			ob_flush();

			flush();

			sleep(1);
			// echo "$htmlContent";
			//获取重定向url
		    $obj = new RedirectUrl("http://b.weizhuanlianmeng.com/ddb/?aid=$aid&platform=1&is_app=1&uid=16772838&from=singlemessage&isappinstalled=1");
		    $realurl = $obj->get_final_url();

		    //get重定向的url
		    $htmlContent = curl_getHtml_string($realurl,$user_agent,$tempTaskIP,$tempTaskIP.".".md5($realurl));

		    sleep(2);
		    // echo "$htmlContent";

		   

		    // $content = curl_get_task_string("http://b.weizhuanlianmeng.com/acc/?callback=$jsonpTime&aid=$aid&uid=16772838",$user_agent,$realurl,$tempTaskIP,$tempTaskIP.".cookie");
		    // sleep(5);
		    // if(!query_taskip_cookie($taskipArray[$i])){


		   	// }

			// print_r($content);

			// break;

			echo "1111111111111111111"."<br>";

		}


		

	}

	//获取毫秒
	function getMillisecond() {

		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
	}
?>


