<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
//библиотека Ratchet и вебсокеты
// как const сделать глобальным, если е его вызываю из функции
class Chat implements MessageComponentInterface {
    protected $clients;
	protected $db_database;
	protected $mysqli;
	public $link;
	
    public function __construct() {
        $this->clients = new \SplObjectStorage; // хранилище с клиентами

		/*$db_database = 'web_technology'; 
		$link = mysqli_connect('localhost','pasha','643105');
		mysqli_select_db($link,$db_database);
		mysqli_select_db($link,$db_database) or die("Нет соединения с БД".mysql_error());
		mysqli_set_charset($link,"utf8");*/
	}
// id name 
// id, name, password, money, predmety, 
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
		// на открытие соединения мы приартачиваем каждый раз клиента 
        $this->clients->attach($conn);
		// и пишем что создано новое соединение
        echo "New connection! ({$conn->resourceId})\n";
		
		// получить данные из ссылки websoket-а
		//$array_person[$conn->resourceId] = $name_person;
    }
	

	// обработка
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
		// как происходит отправка сообщения нас уведомляют
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
		$msgs = json_decode($msg,true);
		
		$db_database = 'web_technology';
		$link = mysqli_connect('localhost','pasha','643105');
		mysqli_select_db($link,$db_database);
		mysqli_select_db($link,$db_database) or die("Нет соединения с БД".mysql_error());
		mysqli_set_charset($link,"utf8");
		
		/*$link2 = mysqli_connect('localhost','pasha','643105');
		mysqli_select_db($link2,$db_database);
		mysqli_select_db($link2,$db_database) or die("Нет соединения с БД".mysql_error());
		mysqli_set_charset($link2,"utf8");*/
		// проверить, есть ли такой пользователь
		
		$stmt = mysqli_stmt_init($link);
		mysqli_stmt_prepare($stmt,'SELECT name,password,currency,inventory FROM person WHERE name = ? and password = ?');// подготавливает запрос
		$bools = mysqli_stmt_bind_param($stmt, 'ss', $msgs[username], $msgs[password]); // связывает параметры с запросом
		mysqli_stmt_execute($stmt); // выполняет запрос
		mysqli_stmt_store_result($stmt); // сохранияет запрос
		
		if(mysqli_stmt_num_rows($stmt) == 0)
		{
			//echo sprintf('\n1234'."\n");
			$msgs[output] = 1;
			//$msgs[message] = 'Пользователя с такими данными не существует!';
			//$from->send($msgs);
			//echo sprintf('\n123411111'."\n");
		}
		else
		{
			mysqli_stmt_bind_result($stmt,$r_name,$r_password,$r_currency,$r_inventory); // запоминаем данные о пользователе
			while(mysqli_stmt_fetch($stmt)){
				$p_name = $r_name;
				$p_password = $r_password;
				$p_currency = $r_currency;
				$p_inventory = $r_inventory;
			}
			$msgs[message] = $p_name;
			mysqli_stmt_close($stmt); // Завершить запрос 
			if($msgs[mode] == "open"){
				$stmt2 = mysqli_stmt_init($link);
				mysqli_stmt_prepare($stmt2,'SELECT price,table_id_skins FROM cases WHERE id = ?'); 
				mysqli_stmt_bind_param($stmt2, 's', $msgs[select_id_case]);
				mysqli_stmt_execute($stmt2);
				mysqli_stmt_store_result($stmt2); 
				if(mysqli_stmt_num_rows($stmt2) == 0)
				{
					$msgs[message] = $msgs[select_id_case];
					//$msgs[message] = 'Такого кейса не существует';
					$msgs[output] = 3;
					mysqli_stmt_close($stmt2);
				}else{
					mysqli_stmt_bind_result($stmt2,$r_price,$r_table_id_skins);
					$price_select_case = 0;
					while(mysqli_stmt_fetch($stmt2)){
						$price_select_case = $r_price;
						$p_table_id_skins = $r_table_id_skins;
					}
					mysqli_stmt_close($stmt2);
					//echo sprintf('12345');
					//$result = mysqli_stmt_get_result($request);
					//$row = mysqli_fetch_array($result, MYSQLI_NUM);
					
					
					if($p_currency < $price_select_case)
					{
						$msgs[output] = 2;
						$msgs[message] = "Не достаточно средств на счету для открытия кейса";
					}
					else
					{
						$msgs[output] = 4;
						$msgs[message] = $r_currency;
						$arr_table_id_skins = explode(',',$p_table_id_skins);
						$msgs[id_skins] = $arr_table_id_skins[rand(0,count($arr_table_id_skins)-1)];
						$msgs[currency] = $p_currency - $price_select_case;
						// вычесть стоимость кейса и записать новый id
						$stmt3 = mysqli_stmt_init($link);
						$p_inventory .= ','.$msgs[id_skins];
						mysqli_stmt_prepare($stmt3,'UPDATE person SET currency = currency - ?, inventory = ? WHERE name = ? AND password = ?');
						mysqli_stmt_bind_param($stmt3, 'dsss', $price_select_case, $p_inventory, $p_name, $p_password);
						mysqli_stmt_execute($stmt3);
					}
					
				}	
			}else if($msgs[mode] == "sell")
			{
				// продать товар
			}else
			{
				// отправить состояние счета и какие товары есть
			}
			//mysgli_fetch_array($request);
		}
		//$msgs[username] = "qwerttttty123";
		//echo sprintf('Person:%s'."\n",$msgs[username]);
		// проверить, хватает ли у пользователя на кейс. Если нет, то в output вернуть сигнал 1
		
		// если все ок то в output вернуть сигнал 0
        foreach ($this->clients as $client) {
			// отправка сообщения всем, кроме отправителя
            if ($from == $client) {
                // The sender is not the receiver, send to each client connected
				$msg2 = json_encode($msgs);
                $client->send($msg2);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
		phpinfo();
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}