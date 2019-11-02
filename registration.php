<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Регистрация</title>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/JavaScript">
	var prohibited_symbols = [',','.','<','>','?','&','*','!','`','"','\'','$',';'];
	var bool_prohibited_symbols_user = false;
	var bool_prohibited_symbols_password = false;
	var bool_prohibited_symbols_prohibited = false;
	function compare_key(position){
		var symbols;
		if(position == 'username'){
			console.log(position);
			symbols = document.querySelector(".user_textbox").value.split('');
			var this_iteration = false;
			for(var i = 0; i< symbols.length; i++)
			{
				for(var j = 0; j< prohibited_symbols.length;j++)
				{
					if(symbols[i] == prohibited_symbols[j])
					{
						this_iteration = true;
					}
				}
			}
			bool_prohibited_symbols_user = this_iteration;
			if(bool_prohibited_symbols_user)
			{
				$(".user_textbox").css("background-color",'red');
				document.querySelector(".text_prohibited_symbols_username").textContent = 'Имя пользователя имеет запрещенные символы';
			}else{
				$(".user_textbox").css("background-color",'white');
				document.querySelector(".text_prohibited_symbols_username").textContent = '';
			}
		}
		else if(position == 'password'){
			console.log(position);
			symbols = document.querySelector(".password_textbox").value.split('');
			var this_iteration = false;
			for(var i = 0; i< symbols.length; i++)
			{
				for(var j = 0; j< prohibited_symbols.length;j++)
				{
					if(symbols[i] == prohibited_symbols[j])
					{
						this_iteration = true;
					}
				}
			}
			bool_prohibited_symbols_password = this_iteration;
			if(bool_prohibited_symbols_password)
			{
				$(".password_textbox").css("background-color",'red');
				document.querySelector(".text_symbols_password").textContent = 'Пароль пользователя имеет запрещенные символы';
			}else{
				$(".password_textbox").css("background-color",'white');
				document.querySelector(".text_symbols_password").textContent = '';
			}
		}
		else {
			console.log(position);
			symbols = document.querySelector(".repeat_textbox").value.split('');
			var this_iteration = false;
			for(var i = 0; i< symbols.length; i++)
			{
				for(var j = 0; j< prohibited_symbols.length;j++)
				{
					if(symbols[i] == prohibited_symbols[j])
					{
						this_iteration = true;
					}
				}
			}
			bool_prohibited_symbols_prohibited = this_iteration;
			if(bool_prohibited_symbols_prohibited)
			{
				$(".repeat_textbox").css("background-color",'red');
				document.querySelector(".text_prohibited_symbols_password").textContent = 'Пароль пользователя имеет запрещенные символы';
			}else{
				$(".repeat_textbox").css("background-color",'white');
				document.querySelector(".text_prohibited_symbols_password").textContent = '';
			}
		}
	}
	function getChar(event) {
		if (event.which == null) { // IE
			if (event.keyCode < 32) return null; // спец. символ
				return String.fromCharCode(event.keyCode)
		}

		if (event.which != 0 && event.charCode != 0) { // все кроме IE
			if (event.which < 32) return null; // спец. символ
				return String.fromCharCode(event.which); // остальные
		}

		return null; // спец. символ
	}
	
	function registration()
	{
		console.log('registration');
		var new_user_name = document.querySelector(".user_textbox").value;
		var new_password = document.querySelector(".password_textbox").value;
		var new_repeat = document.querySelector(".repeat_textbox").value;
		if(new_password != new_repeat)
		{
			alert("Поля 'Password' и 'Repeat' password не совпадают");
		}
		else{
			if(bool_prohibited_symbols_user && bool_prohibited_symbols_password && bool_prohibited_symbols_prohibited && new_user_name.length > 0 && new_password.length > 0 && new_repeat.length)
			{
				var user_data = new_user_name + ',' + new_password;
				jQuery.ajax({
					url: "for_db.php",
					type: "POST",
					data: {mode:6, parametr: user_data}, // Передаем данные для записи
					dataType: "json",
					success: function(result) {
						if (result){ 
							console.log(result);
							alert(result.message);
							if(result.code_error == 3)
							{
								document.location.href = "index.php";
							}
						}else{
							alert(result.message);
						}
						return false;
					}
				});
			}else
			{
				alert("Проверьте проавильность ввода данных");
			}
		}
	}
</script>
</head>
<body>
<a href="index.php">Назад</a>
<div style="position:absolute; left:50%; margin-left:-120px; top:150px; ">
	<p>Username:<input type="text" size="20" onchange="compare_key('username');" class="user_textbox"><i class="text_prohibited_symbols_username"></i></p>
	<p>Password:<input type="password" size="20" onchange="compare_key('password');" class="password_textbox"><i class="text_symbols_password"></p>
	<p>Repeat password: <input type="password" size="20" class="repeat_textbox" onchange="compare_key('repeat');"><i class="text_prohibited_symbols_password"></p>
	<a href="#" onClick="registration();">Регистрация</a>
	<p class="next"></p>
	<br><br><br><br><br><br><br>
</div>
</body>

</html>