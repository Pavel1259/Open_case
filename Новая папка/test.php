<?
$db_database = 'web_technology';
$msgs[username] = 'qwerty';
$msgs[password] = '123';
		$link = mysqli_connect('localhost','pasha','643105');
		mysqli_select_db($link,$db_database);
		mysqli_select_db($link,$db_database) or die("Нет соединения с БД".mysql_error());
		mysqli_set_charset($link,"utf8");
		$stmt = mysqli_stmt_init($link);
	$request = mysqli_stmt_prepare($stmt,"SELECT id,name,password,currency,inventory FROM person WHERE name = ? and password = ?");
		
		mysqli_stmt_bind_param($stmt, "ss", $msgs[username], $msgs[password]);
		mysqli_stmt_execute($stmt);	
		mysqli_stmt_store_result($stmt);
		$msgs[message] = $bools;
		if(mysqli_stmt_num_rows($stmt) == 0)
		{
			echo "Hello!";
		}
		echo $msgs[message]." ";
		echo $msgs[username]." ";
		echo $msgs[password];
		
		
?>