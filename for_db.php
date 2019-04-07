<?
$db_database = "web_technology";
$mysqli = new Mysqli('localhost', 'pasha', '643105', $db_database);
/** Получаем наш ID статьи из запроса */
$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$age = intval($_POST['age']);
$parametr = trim($_POST['parametr']);

//$name = "SELECT name,price FROM cases";
//$db_database = 'base_data';
//$name = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='base_data' AND `TABLE_NAME`='person'";

$name = 'SELECT * FROM base_data.person';
//$name = $_GET['name'];
/** Если нам передали ID то обновляем */
$mode = trim($_POST['mode']);
//$parametr = "qwerty,123";
//$mode = 5;
if($mode or $parametr){
	//вставляем запись в БД
	//$query = $mysqli->query("INSERT INTO `users` VALUES(NULL, '$name', '$surname', '$age')");
	if($mode == 1){ // выдает предметы, которые есть в кейсе
	
		$stmt = $mysqli->prepare('SELECT name, id_case, img, redkost FROM predmety WHERE id_case = ? ORDER BY redkost');
		$arr = explode(',',$parametr);
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($name, $id_case, $img, $redkost);
		while ($stmt->fetch()) {
			$users[name][] = $name;
			$users[id_case][] = $id_case;
			$users[img][] = $img;
			$users[redkost][] = $redkost;
		}
	}
	else if($mode == 2){ // выдает все названия кейсов и их цену
	
		$stmt = $mysqli->prepare('SELECT id, name, price, img, game FROM cases');
		//$arr = explode(',',$parametr);
		//$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($id, $name, $price, $img, $game);
		while ($stmt->fetch()) {
			$users[id][] = $id;
			$users[name][] = $name;
			$users[price][] = $price;
			$users[img][] = $img;
			$users[game][] = $game;
		}
	}
	else if($mode == 3) { // выдает название и цену только одного кейса
	
		$stmt = $mysqli->prepare('SELECT name,price,img FROM cases WHERE id = ?');
		$arr = explode(',',$parametr);
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($name, $price, $img);
		$stmt->fetch(); 
			$users[name][] = $name;
			$users[img][] = $img;
			$users[price][] = $price;
		
	}
	else if($mode == 4){ // выдает название и цену только одного предмета
		$stmt = $mysqli->prepare('SELECT name,price,img FROM predmety WHERE id = ?');
		$arr = explode(',',$parametr);
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			$errors = "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->bind_result($name, $price, $img);
		$stmt->fetch(); 
			$users[name][] = $name;
			$users[price][] = $price;
			$users[img][] = $img;
	}
	else if($mode == 5){ // проверить стстояние счета и инвентаря
		$arr = explode(',',$parametr);
		//$stmt = mysqli_stmt_init($link);
		$stmt = $mysqli->prepare('SELECT name,password,currency,inventory FROM person WHERE name = ? and password = ?');// подготавливает запрос
		$stmt->bind_param('ss', $arr[0], $arr[1]); // связывает параметры с запросом
		$stmt->execute(); // выполняет запрос
		$stmt->store_result(); // сохранияет запрос
		
		if($stmt->num_rows == 0)
		{
			//echo sprintf('\n1234'."\n");
			$errors = "Ошибка! Такого пользователя не существует!";
			$code_error = 1;
			//$msgs[message] = 'Пользователя с такими данными не существует!';
			//$from->send($msgs);
			//echo sprintf('\n123411111'."\n");
		}
		else{
			$stmt->bind_result($r_name,$r_password,$r_currency,$r_inventory);
			while(mysqli_stmt_fetch($stmt)){
				$p_name = $r_name;
				$p_currency = $r_currency;
				$p_inventory = $r_inventory;
			}
			$users[name_person][] = $p_name;
			$inventory_id = explode(',',$p_inventory);
			$users[currency][] = $p_currency;
			mysqli_stmt_close($stmt);
			for($i = 0;$i < count($inventory_id);$i++)
			{
				$res = $mysqli->query("SELECT id,name,price,img FROM predmety WHERE id = ".$inventory_id[$i]);
				while ($row = $res->fetch_assoc()) {
					$users[inventory_id][] = $row["id"];
					$users[inventory_name][] = $row["name"];
					$users[inventory_price][] = $row["price"];
					$users[inventory_img][] = $row["img"];
				}
			}
			 
			
		}	
	}
	else if($mode == 6){ // авторизация
		$arr = explode(',',$parametr);
		//$stmt = mysqli_stmt_init($link);
		$stmt = $mysqli->prepare('SELECT name FROM person WHERE name = ?');// подготавливает запрос
		$stmt->bind_param('s', $arr[0]); // связывает параметры с запросом
		$stmt->execute(); // выполняет запрос
		$stmt->store_result(); // сохранияет запрос
		
		if($stmt->num_rows == 0)
		{
			mysqli_stmt_close($stmt);
			$stmt = $mysqli->prepare('INSERT INTO person(name,password,currency)VALUES(?,?,?)');// подготавливает запрос
			$stmt->bind_param('ssd', $arr[0],$arr[1],500); // связывает параметры с запросом
			$stmt->execute();
			$message = 'Пользователь успешно создан!';
			//$msgs[message] = 'Пользователя с такими данными не существует!';
			//$from->send($msgs);
			//echo sprintf('\n123411111'."\n");
		}
		else{
			mysqli_stmt_close($stmt);
			$errors = "Пользователь с таким именем уже существует!";
		
		}
	}
	
	
	/*
	
	
	if(count($arr) == 1)
	{
		$stmt->bind_param("s", $arr[0]);
		if (!$stmt->execute()) {
			echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else if(count($arr) == 2)
	{
		$stmt->bind_param("ss", $arr[0],$arr[1]);
		if (!$stmt->execute()) {
			echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}else if(count($arr) == 3)
	{
		$bind1 = $arr[0];
		$bind2 = $arr[1];
		$bind3 = $arr[2];
		echo sprintf("%s, %s, %s",$bind1,$bind2,$bind3);
		$stmt->bind_param("ss",$bind2,$bind3);
		
		if (!$stmt->execute()) {
			echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
	else
	{
		$message = $arr[0];
	}
	
	
	$errors = $mysqli->error;
	$message = "";
	if(strlen($errors) == 0)
	{
		if(stristr($name,'SELECT'))
		{
			//извлекаем все записи из таблицы
			$str_arr = explode(' ',$name);
			$st = $str_arr[1];
			if($st != '*')
			{
				$str = explode(',',$st);
				
				for($i = 0, $size = count($str); $i < $size; ++$i)
				{
					$str[$i] = trim($str[$i], '`'); ////
				}
				
				for($i = 0, $size = count($str); $i < $size; ++$i)
				{
					$attrib[$i][] = $str[$i];
				}
			}
			else
			{
				$name_table = $str_arr[3];
				$mysqli2 = new Mysqli('localhost', 'pasha', '643105', 'base_data');
				$name_attrib = $mysqli->query("SELECT `COLUMN_NAME`,`COLUMN_TYPE` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='base_data' AND `TABLE_NAME`='$name_table'");
				$count_s = 0;
				while($name_attrib_list = $name_attrib->fetch_assoc())
				{
					$str[$count_s] = $name_attrib_list['COLUMN_NAME']; // должна быть одна
					// добавить для атрибутов = $name_attrib['DATA_TYPE']
					$count_s = $count_s + 1;
				}
				for($i = 0, $size = count($str); $i < $size; ++$i)
				{
					$attrib[$i][] = $str[$i];
				}
			}
			while($row = $query2->fetch_assoc()){
				for($b = 0, $size = count($str); $b < $size; ++$b)
				{
					$users[$str[$b]][] = $row[$str[$b]];
				}
			}
		}
		else if(stristr($name,'SHOW'))
		{
			$name_attrib = $mysqli->query("$name");
			$count_s = 0;
			while($name_attrib_list = $name_attrib->fetch_assoc())
			{
				$users['TABLE_NAME'][] = $name_attrib_list;
				 // должна быть одна
				$count_s = $count_s + 1;
			}
			
			$attrib[0][] = 'TABLE_NAME';
		}
		else{
			if(stristr($name,'UPDATE')){$message = 'Запись обновлена';}
			else if(stristr($name,'INSERT')){$message = 'Запись вставлена';}
			else if(stristr($name,'DELETE')){$message = 'Запись удалена';}
			else if(stristr($name,'ALTER TABLE')){$message = 'Таблица обновлена';}
			else if(stristr($name,'DROP TABLE')){$message = 'Таблица удалена';}
			else if(stristr($name,'DROP DATABASE')){$message = 'База данных удалена';}
			else if(stristr($name,'CREATE DATABASE')){$message = 'Создана база данных';}
			else if(stristr($name,'CREATE TABLE')){$message = 'Создана таблица';}
		}
	}
	*/
}else{
	$message = 'Введите значение!';
}


/** Возвращаем ответ скрипту */

// Формируем масив данных для отправки
$out = array(
	'str' => $str,
	'attrib' => $attrib,
	'message' => $message,
	'users' => $users,
	'errors' => $errors,
	'code_error' => $code_error
);

// Устанавливаем заголовот ответа в формате json
header('Content-Type: text/json; charset=utf-8');

// Кодируем данные в формат json и отправляем
echo json_encode($out);

