<?
$db_database = "web_technology";
$mysqli = new Mysqli('localhost', 'pasha', '643105', $db_database);
/** Получаем наш ID статьи из запроса */
//$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
//$age = intval($_POST['age']);
$parametr = trim($_POST['parametr']);

$mode = trim($_POST['mode']);

if($mode or $parametr){
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
		$stmt = $mysqli->prepare('SELECT name,password,currency,inventory FROM person WHERE name = ? and password = ?');// подготавливает запрос
		$stmt->bind_param('ss', $arr[0], $arr[1]); // связывает параметры с запросом
		$stmt->execute(); // выполняет запрос
		$stmt->store_result(); // сохранияет запрос
		
		if($stmt->num_rows == 0)
		{
			$errors = "Ошибка! Такого пользователя не существует!";
			$code_error = 1;
			//$msgs[message] = 'Пользователя с такими данными не существует!';
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
		$stmt = $mysqli->prepare('SELECT name FROM person WHERE name = ?');// подготавливает запрос
		$stmt->bind_param('s', $arr[0]); // связывает параметры с запросом
		$stmt->execute(); // выполняет запрос
		$stmt->store_result(); // сохранияет запрос
		
		if($stmt->num_rows == 0)
		{
			mysqli_stmt_close($stmt);
			// проверка на запрещенные символы
			$arr_symbol = array(',','.','<','>','?','&','*','!','&');
			$bool_prohibited_symbols = false;
			for($i = 0;$i<count($arr);$i++)
			{
				for($j = 0;$j < count($arr_symbol); $j++)
				{
					if(stristr($arr[$i],$array_s[$j]))
					{
						$bool_prohibited_symbols = true;
					}
				}
			}
			if($bool_prohibited_symbols)
			{
				$message = 'Данные пользователя имеют запрещенные символы';
				$code_error = 2;
			}
			else
			{
				$start_balanse = 500;
				$stmt = $mysqli->prepare('INSERT INTO person(name,password,currency)VALUES(?,?,?)');// подготавливает запрос
				$stmt->bind_param('ssd', $arr[0],$arr[1],$start_balanse); // связывает параметры с запросом
				$stmt->execute();
				$message = 'Пользователь успешно создан!';
				$code_error = 3;	
				//$msgs[message] = 'Пользователя с такими данными не существует!';
			}
		}
		else{
			mysqli_stmt_close($stmt);
			$errors = "Пользователь с таким именем уже существует!";
		}
	}
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

