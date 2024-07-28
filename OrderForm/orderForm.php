<?php
include_once 'pizzas.php'; //подгружаем массив с нашими пиццами

//создаем опции, которые позволят клиенту выбирать пиццу из списка <select>
$options = '<option value="0">Выберите пиццу</option>';
foreach ($pizzas as $pizza){
	$options .= '<option value="' . $pizza["id"] . '">' . $pizza["name"] . ' ' . ' (' . $pizza["price"] . '€)</option>';
}

//создаем в js массив с ценами пицц, чтобы можно было потом посчитать "Итого" в файле javascript.js
$jsArray = "<script>";
$jsArray .= "var pizzaPrizes = {};";
foreach ($pizzas as $pizza){
	$jsArray .= "pizzaPrizes[" . $pizza["id"] . "] = " . $pizza["price"] . ";";
}
$jsArray .= "</script>";
echo $jsArray;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="assets/style.css">
		<script src="assets/javascript.js"></script>
	</head>
	<body>
		<div class="container">
			<img src="images/pizzeria.png" alt="Pizzeria" class="image">
			<div class="form">
				<h2>Заказ</h2>
				<form action="OrderForm/sendOrder.php" method="POST">
					<input type="text" name="name" placeholder="Имя" required>
					<input type="email" name="email" placeholder="Емайл" required>
					<input type="text" name="phone" placeholder="Телефон" required>
					<input type="text" name="address" placeholder="Адрес" required>
					<div id="pizzas-container">
						<div class="template">
							<select onchange="onChange(event)" name="pizza[]"><?php echo $options; ?></select>
							<input onchange="onChange(event)" type="number" name="count[]" placeholder="Количество" min="1" max="100" value="1">
						</div>
						<div class="pizza">
							<select onchange="onChange(event)" name="pizza[]"><?php echo $options; ?></select>
							<input onchange="onChange(event)" type="number" name="count[]" placeholder="Количество" min="1" max="100" value="1">
						</div>
					</div>
					<div class="total">Итого: <span id="total">0</span>€</div>
					<input type="submit" name="submit" value="ЗАКАЗАТЬ">
				</form>
			</div>
		</div>
		<div class="footer">
			Dzessika Tverskaja JKTV22 2023
		</div>
	</body>
</html>
