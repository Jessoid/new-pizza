<?php
include_once 'pizzas.php'; //подгружаем массив с нашими пиццами

//принимаем и проверяем POST данные с формы
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phone"]);
$address = trim($_POST["address"]);
$pizzasIds = $_POST["pizza"];
$counts = $_POST["count"];

if (empty($name)){
	echo "Введите имя!";
	return;
} else if (empty($email)){
	echo "Введите емайл!";
	return;
} else if (empty($phone)){
	echo "Введите телефон!";
	return;
} else if (empty($address)){
	echo "Введите адрес!";
	return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$emailErr = "Неверный емайл!";
	return;
}

$pizzasOrdered = 0;
foreach ($pizzasIds as $k => $pizzaId){
	if ($pizzaId > 0){
		$pizzasOrdered++;
	} else{
		unset($pizzasIds[$k]); //отчищаем массив от лишних данных, оставляем только реальные заказы
		unset($counts[$k]); //отчищаем массив от лишних данных, оставляем только реальные заказы
	}
}

if ($pizzasOrdered === 0){
	echo "Добавьте пиццу!";
	return;
}

$pizzasHtml = "";
$pizzasEmailHtml = "";
$totalPrice = 0;
$pizzasCount = 0;
foreach ($pizzasIds as $k => $pizzaId){ //пробегаемся по id пицц, которые заказал клиент
	foreach ($pizzas as $pizza){ //пробегаемся по массиву из всех пицц
		if ($pizza["id"] != $pizzaId){ //ищем пиццу из массива пицц с нужным нам id, если не та, то пропупскаем
			continue;
		}
		
		//если данные пиццы найдены, то создаем html элементы для отчета
		$pizzasHtml .= 
				'<div class="row">
					<div class="pizza-data">
						<div class="pizza-img" style="background-image:url(../images/' . $pizzaId . '.jpg);"></div>
						<div class="pizza-name">' . $pizza["name"] . ' (' . $pizza["price"] . '€)</div>
					</div>
					<div>' . $counts[$k] . ' шт.</div>
				</div>';
				
		$pizzasEmailHtml .= 
				'<tr>
					<td>' . $pizza["name"] . ' (' . $pizza["price"] . '€)</td>
					<td>' . $counts[$k] . ' шт.</td>
				</tr>';
		
		$totalPrice += floatval($pizza["price"] * $counts[$k]); //считаем итоговую цену
		$pizzasCount = $pizzasCount + $counts[$k]; //считаем сколько пицц заказано
	}
}

/*
* Прогнозируем время доставки
* Время на изготовление 1 пиццы - ~15 минут.
* Время доставки - ~20 минут.
*/
$timeInMinutes = ($pizzasCount * 15) + 20;

sendEmail($email, $name, $phone, $address, $timeInMinutes, $pizzasEmailHtml, $totalPrice);

include_once 'answerOrder.php'; //ответ клиенту

function sendEmail($email, $name, $phone, $address, $timeInMinutes, $pizzasEmailHtml, $totalPrice){
	$to = $email . ", admin@pizza.com"; //емайл администратора - admin@pizza.com, а клиента с формы
	$subject = "Подтверждение заказа";

	$message = "
		<html>
			<head>
				<title>Спасибо за заказ!</title>
			</head>
			<body>
				<p><b>Спасибо за заказ!</b></p>
				<table>
					<tr>
						<td>Имя:</td>
						<td>" . $name . "</td>
					</tr>
					<tr>
						<td>Емайл:</td>
						<td>" . $email . "</td>
					</tr>
					<tr>
						<td>Телефон:</td>
						<td>" . $phone . "</td>
					</tr>
					<tr>
						<td>Адрес:</td>
						<td>" . $address . "</td>
					</tr>
				</table>
				<br>
				<table>
					" . $pizzasEmailHtml . "
				</table>
				<p><b>Итого: " . number_format($totalPrice, 2) . "€</b></p>
				<p><b>Заказ будет готов и доставлен примерно через " . $timeInMinutes . " минут!</b></p>
			</body>
		</html>
	";

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	//От кого письмо
	$headers .= 'From: <webmaster@example.com>';

	mail($to,$subject,$message,$headers);
}

?>
