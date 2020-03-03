<?php


//Подключим config файл для соединения с БД
require_once('config.php');


//Читаем из БД данные о покупке
$sqltxt="SELECT * FROM `sales` WHERE `id`='".$argv[3]."'";
$raw_result = mysqli_query($conn,$sqltxt) or die(mysqli_error($conn));

if (mysqli_num_rows($raw_result) == 0) {
//Если нет покупки с заданным id, выводим сообщение и остановим скрипт
	echo 'Нет записи о покупке с id='.$argv[3];
	exit();

} else {
//Если есть покупка с заданным id, запишем товар и цену в переменные
$result = mysqli_fetch_array($raw_result);

$product=$result['product'];
$price=$result['price'];

}


//Читаем из БД данные о клиенте
$sqltxt="SELECT * FROM `clients` WHERE `id`='".$argv[2]."'";
$raw_result = mysqli_query($conn,$sqltxt) or die(mysqli_error($conn));

if (mysqli_num_rows($raw_result) == 0) {
//Если нет клиента с заданным id, выводим сообщение и остановим скрипт
	echo 'Нет клиента с id='.$argv[2];
	exit();

} else {
//Если есть клиент с заданным id
	$result = mysqli_fetch_array($raw_result);
	
	if ($argv[1]=='email') {
	//Если первый параметр указывает на отправку электронной почты, вызываем соответствующую функцию
		echo sendemail($result['email'], 'You bought: '.$product.' - '.$price.'$');
		$client=$result['email'];
		
	} elseif ($argv[1]=='phone') {
	//Если первый параметр указывает на отправку смс сообщения, вызываем соответствующую функцию
		echo sendsms($result['phone'], 'You bought: '.$product.' - '.$price.'$');
		$client=$result['phone'];
		
	} else {
	//Если введенный параметр не равен существующим способам уведомления, выводим сообщение и остановим скрипт
		echo 'Не существует такого способа уведомления ("'.$argv[1].'"). Существующие способы: phone, email';
		exit();
		
	}

$sqltxt="INSERT INTO `logs`(`client`, `sale`) VALUES ('".$client."', '".$argv[3]."')";
mysqli_query($conn,$sqltxt) or die(mysqli_error($conn));

}


//Функция для отправки sms
function sendsms($phone, $text){
//Здесь должна быть функция, и ссылка с GET параметрами для отправки смс
//Например: file_get_contents("https://www.web-service.com/sms?phone=".$phone."&text=".$text);

return 'phone: '.$phone.'
text:  '.$text.'
notification sent';
	
}


//Функция для отправки электронной почты
function sendemail($email, $text){
//Здесь должна быть функция, и ссылка с GET параметрами для отправки электронной почты
//Например: file_get_contents("https://www.web-service.com/email?email=".$email."&text=".$text);

return 'email: '.$email.'
text:  '.$text.'
notification sent';

}


?>
