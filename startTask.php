<?php 
	
	require_once("redirectUrl.php");

	echo "开始测试";
	echo "<br>";
	error_reporting(0);
	$allTaskArray = array();

	// $myColumnArr = getTaskColumnId();

	// $taskUrlArr = getAllTask($myColumnArr);

	// saveTaskToDB($taskUrlArr);


	// $willStartTaskArr = getNotCompleteTask();
	// printf($willStartTaskArr);
	// startTask($willStartTaskArr);

	$url = 'http://www.artcm.cn/customer/login/';

	$password = "I2brxrF\/FFvKsNr+JnMAoKhyxYZSHWp5P2B8kmzWvZZBM6M3NzVEe997pamXfozLTxExFq80xeLtb++uj6+THg8mhEiiTO+7EBCCsM+V1NsFBjYuck1tAbB20ypO8L1K9Mw70Ey8QRA9n2v9YqY2MBOx1Rn5yv+zOhSFnSiP3eg=";

	$user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";
	$test_post_data = array('username' => '13814057793', 'password' => $password);

	test_Cookie($url,$test_post_data,$user_agent);

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
		$cookie_jar = dirname(__FILE__)."/pic.cookie";

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

	function curl_getHtml_string ($url,$user_agent,$cheatip){

		$ch = curl_init();
		print_r($cheatip);

		echo "<br>";

		curl_setopt ($ch, CURLOPT_URL, $url);

		// 抓包 start
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// 抓包 end

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

	function curl_get_task_string ($url,$user_agent,$referer,$cheatip){

		$ch = curl_init();
		echo "<br>";

		curl_setopt ($ch, CURLOPT_URL, $url);

		// 抓包 start
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
		// 抓包 end

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
		$result = array_slice($taskArr,0,6); 
		echo "<br>";

		$tempArray = array();

		for ($i=0;$i<6;$i++){

			$item =  $result[$i];

			$tempArray[] = $item;
			// echo $item['Taskurl']."<br>";
		}


		$tempurl =  $tempArray[0]['Taskurl'];
		$aid =  $tempArray[0]['Aid'];
		$user_agent = "Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)";
		$jsonpTime = 'jsonp'. getMillisecond();

		//get原始页面
		$htmlContent = curl_getHtml_string($tempurl,$user_agent,"223.104.4.213");
		echo "$htmlContent";
		//获取重定向url
	    $obj = new RedirectUrl("http://b.weizhuanlianmeng.com/ddb/?aid=$aid&platform=1&is_app=1&uid=16772838&from=singlemessage&isappinstalled=1");
	    $realurl = $obj->get_final_url();

	    //get重定向的url
	    $htmlContent = curl_getHtml_string($realurl,$user_agent,"223.104.4.213");

	    echo "$htmlContent";

	    $content = curl_get_task_string("http://b.weizhuanlianmeng.com/acc/?callback=$jsonpTime&aid=$aid&uid=16772838",$user_agent,$realurl,"223.104.4.213");
		print_r($content);

	}

	//获取毫秒
	function getMillisecond() {

		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
	}
?>


