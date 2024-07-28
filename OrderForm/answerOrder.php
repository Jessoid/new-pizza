<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../assets/style.css">
	</head>
	<body>
		<div class="container">
			<img src="../images/pizzeria.png" alt="Pizzeria" class="image">
			<div class="form">
				<h2>Спасибо за заказ!</h2>
				<div class="row">
					<div>Имя:</div>
					<div><?php echo $name; ?></div>
				</div>
				<div class="row">
					<div>Емайл:</div>
					<div><?php echo $email; ?></div>
				</div>
				<div class="row">
					<div>Телефон:</div>
					<div><?php echo $phone; ?></div>
				</div>
				<div class="row">
					<div>Адрес:</div>
					<div><?php echo $address; ?></div>
				</div>
				<hr>
				<?php echo $pizzasHtml; ?>
				<hr>
				<div class="total">Итого: <?php echo number_format($totalPrice, 2); ?>€</div>
				<h3>Заказ будет готов и доставлен примерно через <?php echo $timeInMinutes; ?> минут!</h3>
			</div>
		</div>
	</body>
</html>
