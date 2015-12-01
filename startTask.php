<?php 

	echo "开始任务";
	echo "<br>";
	error_reporting(0);

	getTask();


	function getTask()
	{
		// http://zhuan.9766.com/index/neice.php?c=weizhuan&m=api&a=articles_ios cid=2

		$post_data = array ('token' => '754971d1eec66bb38176d8c4cedbacd9','uid' => '16772838','cid' =>'2' ,'page_end' => '10','page_sta' => '1');

		$user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";

		$url_page = "http://zhuan.9766.com/index/neice.php?c=weizhuan&m=api&a=articles_ios";


		$jsonContent = curl_string($url_page,$user_agent,$post_data,"223.104.4.121");

		print_r($jsonContent);

		$content = json_decode($jsonContent);


		print_r($content);
	}

	function startTask()
	{
		
	}


	function curl_string ($url,$user_agent,$post_data,$cheatip){

		$ch = curl_init();


		print_r($post_data);

		print_r($url);

		print_r($user_agent);

		print_r($cheatip);

		echo "<br>";

		// print_r(array('Content-Type' => 'application/x-www-form-urlencoded', "CLIENT-IP:$cheatip", "X-FORWARDED-FOR:$cheatip"));
		echo "<br>";
		// echo  "json_encode($post_data)";
		// return;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data)); 
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		$cookie_file = tempnam('./temp','cookie'); 
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'application/x-www-form-urlencoded', "CLIENT-IP:$cheatip", "X-FORWARDED-FOR:$cheatip"));  //此处可以改为任意假IP
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);

		$result = curl_exec ($ch);
		curl_close($ch);
		return $result;
	}

	// $url_page = "http://localhost/getip.php";
	// $user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";
	// // $proxy = "http://115.148.25.187:9000";    //此处为代理服务器IP和PORT高级匿名代理
	// $string = curl_string($url_page,$user_agent,$proxy);

	// echo $string;

	// echo "<br>";
	echo "结束任务";
	echo "<br>";


	

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


	function getRandIp ($ipType){

		//range 是将1到100 列成一个数组 
		$numbers = range (0,255); 
		//shuffle 将数组顺序随即打乱 
		shuffle ($numbers); 
		//array_slice 取该数组中的某一段 
		$no=30; 
		$result = array_slice($numbers,0,$no); 
		for ($i=0;$i<$no;$i++){ 
			echo $result[$i]."<br>"; 
		} 

		return $result;
	}

?>
