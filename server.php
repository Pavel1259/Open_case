<?php
  namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

  header('Content-Type: text/plain; charset=UTF-8'); //Мы будем выводить простой текст
  mb_internal_encoding('UTF-8'); // Установка внутренней кодировки в UTF-8
  mb_http_output('UTF-8'); // Установка кодировки UTF-8 входных данных HTTP-запроса
  mb_http_input('UTF-8'); // Установка кодировки UTF-8 выходных данных HTTP-запроса
  mb_regex_encoding('UTF-8'); // Установка кодировки UTF-8 для многобайтовых регулярных выражений 

  $clients = new \SplObjectStorage;
  set_time_limit(0); //Скрипт должен работать постоянно
  ob_implicit_flush(); //Все echo должны сразу же отправляться клиенту
  $address = 'localhost'; //Адрес работы сервера
  $port = 1985; //Порт работы сервера (лучше какой-нибудь редкоиспользуемый)
  if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
	//AF_INET - семейство протоколов
    //SOCK_STREAM - тип сокета
    //SOL_TCP - протокол
    echo "Oshibka sozdaniya soketa\n";
  }
  else {
	echo "Soket sozdan\n";
  }
  //Связываем дескриптор сокета с указанным адресом и портом
  if (($ret = socket_bind($sock, $address, $port)) < 0) {
    echo "Oshibka svjazi soketa s adresom i portom\n";
  }
  else {
    echo "Soket yspeshno svjazan s adresom i portom\n";
  }
  //Начинаем прослушивание сокета (максимум 5 одновременных соединений)
  if (($ret = socket_listen($sock, 5)) < 0) {
    echo "Oshybka pri popytke proslysivaniya soketa";
  }
  else {
    echo "/Jdem podklychenie kienta\n";
  }
  //
  echo "111\n";
  //
  do {
	  echo "333\n";
    //Принимаем соединение с сокетом
    if (($msgsock[] = socket_accept($sock)) < 0) {
      echo "Oshibka pri starte soedinenyi s soketom";
    } else {
      echo "Soket gotov k priemy soobsheniy\n";
    }
	echo "444\n";
    $msg = "Hello!"; //Сообщение клиенту
    echo "Soobshenie ot servera: $msg";
	foreach($msgsock as $clientSock)
	{
		socket_write($clientSock, $msg, strlen($msg)); //Запись в сокет
		//Бесконечный цикл ожидания клиентов
		echo "222\n";
		// 48 63
		
		echo 'Сообщение от клиента: ';
		if (false === ($buf = socket_read($clientSock, 1024))) {
			echo "/oshibka pri chtenii soobsheniya ot clienta";       }
		else {
			echo $buf."\n"; //Сообщение от клиента
		}
        //socket_close($clientSock);
		//Если клиент передал exit, то отключаем соединение
		if ($buf == 'exit') {
			break 2;
		}
		if (!is_numeric($buf)) echo "Soobshenie ot servera: peredano NE chislo\n";
		else {
			$buf = $buf * $buf;
			$buf = $buf * $buf;
			echo "Soobshenie ot servera: ($buf)\n";
		}
		socket_write($clientSock, $buf, strlen($buf));
		socket_write($clientSock, $buf, strlen($buf));
	}
  } while (true);
  //Останавливаем работу с сокетом
  if (isset($sock)) {
    socket_close($sock);
    echo "Soket uspeshno zakryt\n";
  }
?>