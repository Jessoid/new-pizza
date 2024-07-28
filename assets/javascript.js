var currentPizzasCount = 0; //количество активных пицц клиента

function onChange(event) {
	calculateTotal(); //когда произошло изменение пиццы или количества, пересчитываем "Итого"
	
	//проверяем, нужно ли добавить новую строку для добавления пиццы
	if (currentPizzasCount == document.getElementsByClassName("pizza").length){ //если все имеющиеся слоты заняты, то нужно добавить новую строку
		var pizzasContainer = document.getElementById("pizzas-container");
		var pizzaTemplate = document.getElementsByClassName("template")[0]; //берем наш шаблон пиццы,самый первый элемент
		var clonedPizzaTemplate = pizzaTemplate.cloneNode(true); //клонируем этот шаблон
		
		clonedPizzaTemplate.classList.remove("template"); //удаляем класс template в клоне, чтобы элемент стал видимым
		clonedPizzaTemplate.classList.add("pizza"); //добавляем элементу-клону класс pizza
		
		pizzasContainer.appendChild(clonedPizzaTemplate); //и добавляем в конец контейнера с пиццами, чтобы можно клиенту было добавить еще одну пиццу, если захочет
	}
}

function calculateTotal(){
	var totalElement = document.getElementById("total");
	var total = 0;
	currentPizzasCount = 0;
	
	var pizzas = document.getElementsByClassName("pizza");
	for (var i = 0; i < pizzas.length; i++) { //пробегаемся по всем пиццам в форме
	   var pizzaId = pizzas.item(i).children[0].value; //пицца (id)
	   var count = pizzas.item(i).children[1].value; //количество
	   
	   if (pizzaId == 0){ //пицца не выбрана
		   continue;
	   }
	   
	   total += pizzaPrizes[pizzaId] * count;
	   currentPizzasCount++;
	}
		
	totalElement.innerHTML = total.toFixed(2);
}
