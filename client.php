<?$db_host   = 'localhost';
$db_user   = 'pasha';
$db_pass   = '643105';
$db_database = "web_technology";

$link = mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_database,$link);
mysql_select_db($db_database,$link) or die("Нет соединения с БД".mysql_error());
mysql_query("SET NAMES utf8");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Клиент</title>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/JavaScript">
var socket;
// статус пользователя сделать через сокеты
var t;
var select_id_case = 1;
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}
function close_banner_1(){
	jQuery('.banner div').remove();
}
function close_banner_get_skin(){
	jQuery('.get_skin').remove();
}
function update_info_person()
{
	var user_data = 
	jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:5, parametr: null}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
					jQuery('.rows tr').remove();
                    jQuery('.rows').append(function(){
						t = result;
						console.log(result);
						var res = '<tr><td><b>Кейсы</b></td></tr>';
						res += '<tr>';
						for(var i = 0; i < result.users['name'].length; i++){
							
								res += "<td><a href='#' onClick='select_id_case="+result.users["id"][i]+";select_case();'>"+ result.users["name"][i] + " "+ result.users['price'][i] +"</a></td>";
								//res+="<td><span style='margin-left:100px;'></span><a href='#' onClick=\"select_database='"+ result.users['TABLE_NAME'][i].Database +"'; delete_database();\">Удалить</a></td>";
								//res += '<tr><td>' + result.users[id] + '</td><td>' + result.users.name[i] + '</td><td>' + result.users.surname[i] + '</td><td>' + result.users.age[i] + '</td></tr>';
						}
						res += '</tr>';
						t = res;
							return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
    });
}
function update_page(){
	// обновлять кейсы 
	
	jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:2, parametr: null}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
					jQuery('.rows tr').remove();
                    jQuery('.rows').append(function(){
						t = result;
						console.log(result);
						var res = '<tr><td><b>Кейсы</b></td></tr>';
						res += '<tr>';
						for(var i = 0; i < result.users['name'].length; i++){
							
								res += "<td><a href='#' onClick='select_id_case="+result.users["id"][i]+";select_case();'>"+ result.users["name"][i] + " "+ result.users['price'][i] +"</a></td>";
								//res+="<td><span style='margin-left:100px;'></span><a href='#' onClick=\"select_database='"+ result.users['TABLE_NAME'][i].Database +"'; delete_database();\">Удалить</a></td>";
								//res += '<tr><td>' + result.users[id] + '</td><td>' + result.users.name[i] + '</td><td>' + result.users.surname[i] + '</td><td>' + result.users.age[i] + '</td></tr>';
						}
						res += '</tr>';
						t = res;
							return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
    });
}
function select_case(){
	jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:3, parametr:select_id_case}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
					jQuery('.banner div').remove();
                    jQuery('.banner').append(function(){
						t = result;
						console.log(result);
						var res = '<div style="position: fixed; left:100px; top:300px; heigth:500px; width:1000px; background-color:gray;" class="block_fixed">';
						res += '<input type="button" name="close_banner_1" value="Закрыть" onClick="close_banner_1();"';
						res += '<h2>'+result.users["name"][0]+'</h2>';
						res += '<h3>'+result.users["price"][0]+'</h3>';
						
						return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
    });
	sleep(500);
	jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:1,parametr:select_id_case}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
                    jQuery('.block_fixed').append(function(){
						t = result;
						console.log(result);
						var res = '<input type="button" name="open_case_button" value="Открыть" onClick="var select_id_case ='+select_id_case+';open_case_function();">';
						
						for(var i = 0; i<result.users["name"].length;i++)
						{
							res += '<span style="width:50px;">';
							res += '<img src="'+result.users["img"][i]+' width="50px"/>';
							res += '<h3>'+result.users["name"][i]+'</h3>';
						}
						
						res += '</div>';
						return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
    });
	
	
}

function open_case_function(){
	var message = {
			username: "qwerty",
			password: "123",
			currency: 0,
			id_skins: "",
			mode: "open",
			select_id_case: select_id_case,
			select_id_skin: 1,
			output: 1,
			message: 1
		}
		socket.send(JSON.stringify(message));
		return false;
}
function sell_skin_function(){
	var message = {
			username: "qwerty",
			password: "123",
			currency: 0,
			id_skins: "",
			mode: "sell",
			select_id_case: 1,
			select_id_skin: 1,
			output: 1,
			message: 1
		}
		socket.send(JSON.stringify(message));
		return false;
}
function info_account_function(){
	var message = {
			username: "qwerty",
			password: "123",
			currency: 0,
			id_skins: "",
			mode: "info",
			select_id_case: 1,
			select_id_skin: 1,
			output: 1,
			message: 1
		}
		socket.send(JSON.stringify(message));
		return false;
}
</script>
</head>
<body>

<table class="rows">
<script>update_page();</script>
</table>
<table>
<tr>
	<td>
		<p>Пользователь:</p>
		<p>Баланс:</p>
		<div id="status"></div>
	</td>
</tr>

</table>

<div class="banner">
	<!--<div style="position: relative; left:10px; heigth:500px; width:500px; background-color:red;">
	<p>1</p>
	</div>
	<div style="position: absolute; left:10px; heigth:500px; width:500px; background-color:red;">
	<p>1</p>
	</div>-->
	<div style="position: fixed; left:100px; top:300px; heigth:500px; width:1000px; background-color:gray;">
	<p>1</p>
	</div>
</div>
<script>
window.onload = function(){
	//var socket = new WebSocket("ws://echo.websocket.org");
	//const new_name_user;
	
	const new_name_user = prompt("Введите имя пользователя","");
	if(new_name_user == null)
	{
		alert("Перезагрузить страницу");
	}
	console.log(new_name_user);
	var new_password_user;
	do{
		new_password_user = prompt("Введите пароль","");
	}while(new_password_user == null)
	console.log(new_password_user);
	// проверяем
	socket = new WebSocket("ws://localhost:8080");
	var status = document.querySelector("#status");
	// открытие соединения
	socket.onopen = function(){
		status.innerHTML = "соединение установлено";
	}
	
	// закрытие соединения
	socket.onclose = function(event){
		if(event.wasClean){
			console.log("соединение закрыто");
		}else{
			console.log("соединение как-то закрыто");
		}
		console.log("код" + event.code + " причина: " + event.reason);
	}
	
	// получение данных
	socket.onmessage = function(){
		//status.innerHTML = "Пришли данные" + event.data;
		var message = JSON.parse(event.data);
		console.log(message);
		// код ошибки
		// 1 - нет такого пользователя
		// 2 - не достаточно средств на счету
		// 3 - такого кейса не существует
		// 4 - кейс открыт
		// 5 - товар продан
		// 6 - состояние счета и какие есть выигранные предметы
		if(message.output == 1){
			alert("Пользователя с такими данными не существует!");
			//window.location.reload();
		}
		else if(message.output == 2){
			alert(message.message);
		}
		else if(message.output == 3){
			alert(message.message);
		}
		else if(message.output == 4)
		{
			// сделать анимацию прокрутки
			/*jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:4, parametr: message.id_skins}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
                    jQuery('.banner').append(function(){
						var res = '<div class="get_skin" style="position: fixed; left:150px; top:150px; heigth:500px; width:1000px; background-color:#2196F3;;" class="block_fixed">';
						res += '<img src="'+result.users["img"][0]+'" width="600px" />';
						res += '<a href="#" style="position:fixed; left:700px; top:155px;" onClick="close_banner_get_skin();">Закрыть</div>';
						res += '</div>';
						return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
			}); */
			// закрыть анимацию и вызвать через функцию то что ниже
			jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:4, parametr: message.id_skins}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
                    jQuery('.banner').append(function(){
						var res = '<div class="get_skin" style="position: fixed; left:150px; top:150px; heigth:500px; width:1000px; background-color:#2196F3;;" class="block_fixed">';
						res += '<img src="'+result.users["img"][0]+'" width="600px" />';
						res += '<a href="#" style="position:fixed; left:700px; top:155px;" onClick="close_banner_get_skin();">Закрыть</div>';
						res += '</div>';
						return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
			});
		}
		else if(message.output == 5){
			
		}
		else if(message.output == 6){
			
		}
		status.innerHTML = "Пришли даные: " + message.select_id_case + "<br>Message:" + message.message + "<br>Output:" + message.output + "<br>Skins:" + message.id_skins;
	}
	
	// возникновение ошибки
	socket.onerror = function(){
		status.innerHTML = "Ошибка: " + event.message;
	}
	// отправка
	jQuery(".take").bind("click", function() {
		var message = {
			name: "Hello!!!",
			msg: "Web"
		}
		socket.send(JSON.stringify(message));
		return false;
	});
}
</script>
</body>

</html>