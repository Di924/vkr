<?php
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_EMAIL);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_EMAIL);

if(mb_strlen($login) < 5 || mb_strlen($login) > 90){
    echo "Недопустимая длина логина!";
    exit();
}else if(mb_strlen($name) < 2 || mb_strlen($name) > 20){
    echo "<p>Недопустимая длина имени! Не используйте одну букву и не пишите ФИО. Достаточно просто имени или никнейма.</p>";
    exit();
}else if(mb_strlen($pass) < 8 || mb_strlen($pass) > 50){
    echo "<p>Недопустимая длина пароля! Пароль должен содержать от 8 до 50 символов.</p>";
    echo "<p>Используйте для пароля цифры и символы.</p>";
    exit();
}else{
   echo "Ожидайте окончания операции."; 

    $pass = md5($pass);

   $mysql = new mysqli('localhost','root','','register');
   $mysql->query("INSERT INTO `users` (`login`, `pass`, `name`) VALUES('$login', '$pass', '$name');");
   $mysql->close();
   header('location:/www/vkr/');
   exit();
}

?>