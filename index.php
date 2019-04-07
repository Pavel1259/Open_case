<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Старт</title>
<script src="jquery-1.7.2.min.js"></script>
<script>
function Login_user(){
	var user_data = document.querySelector(".textBox_username").value + ',' + document.querySelector(".textBox_password").value;
	jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {mode:5, parametr: user_data}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
					console.log(result);
					if(result.code_error == 1)
					{
						$(".textBox_username").css("background-color",'red');
						$(".textBox_password").css("background-color",'red');
						document.querySelector(".info_connect").innerHTML = result.errors;
					}
					else{
						window.location.href='client.php?' + document.querySelector(".textBox_username").value + '&' + document.querySelector(".textBox_password").value;
					}
                }else{
                    alert(result.message);
                }
				return false;
            }
    });
}
</script>
</head>
<body>
<div style="position:absolute; left:50%; margin-left:-120px; top:150px; ">
	<span>Username:</span><input type="text" size="20" class="textBox_username"><br>
	<span>Password:</span><input type="password" size="20" class="textBox_password"></br>
	<span class="info_connect"></span></br>
	<a href="#" onClick="Login_user();" class="login">Войти</a>
	<br><br>
	<a href="registration.php">Регистрация</a>
	<a href="https://csgoitems.pro/ru/collections/all">Полынй список скинов</a>
</div>
<div></div>
<br><br><br><br><br><br><br>


</body>

</html>