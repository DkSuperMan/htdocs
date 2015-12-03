<html>
	<body>

	<?php 

	$name = $_GET["name"]; 

	if($name == "111111"){
		echo "name is $name";
		// header('Location: redirectUrl.php');
		header('Location: startTask.php');
	}else{
		echo "userName error!";
	}

	?>

	<br>

	</body>
</html>