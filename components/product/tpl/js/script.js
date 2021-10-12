window.onload = function(e){ 
var cartData = getCartData() || {};
console.log(cartData);
var cartPrice=0;
        var cartCount=0;
        for(var items in cartData){
            cartPrice+=cartData[items][1]*cartData[items][2];
            cartCount+=cartData[items][2];
        }
        document.getElementById('cartno').innerHTML=cartCount;
        document.getElementById('cartsum').innerHTML=cartPrice;

var d = document;
var itemBox = d.querySelectorAll('div.item_box'); // блок каждого товара
var cartCont = d.getElementById('cart_content'); // блок вывода данных корзины
    //console.log(itemBox);
    for(var i = 0; i < itemBox.length; i++){
        //console.log(itemBox[i]);
	addEvent(itemBox[i].querySelector('.add_item'), 'click', addToCart);
    }
// Функция кроссбраузерная установка обработчика событий
function addEvent(elem, type, handler){
    if(elem){
  if(elem.addEventListener){
    elem.addEventListener(type, handler, false);
  } else {
    elem.attachEvent('on'+type, function(){ handler.call( elem ); });
  }
    }
  return false;
}
// Получаем данные из LocalStorage
function getCartData(){
	return JSON.parse(localStorage.getItem('cart'));
}
// Записываем данные в LocalStorage
function setCartData(o){
	localStorage.setItem('cart', JSON.stringify(o));
	return false;
}
//Редактирование корзины
function editCart(id,amount){
    cartData = getCartData() || {};
    console.log('id',id,'amount', amount, 'data', cartData );
    cartData[id][2] = parseInt(amount);
    setCartData(cartData);
}
// Добавляем товар в корзину
function addToCart(e){
	this.disabled = true; // блокируем кнопку на время операции с корзиной
	var cartData = getCartData() || {}, // получаем данные корзины или создаём новый объект, если данных еще нет
			parentBox = this.parentNode, // родительский элемент кнопки &quot;Добавить в корзину&quot;
			itemId = this.getAttribute('data-id'), // ID товара
			itemTitle = parentBox.querySelector('.item_title').innerHTML, // название товара
                        itemImage = parentBox.querySelector('#image').value,
			itemPrice = parentBox.querySelector('.item_price').innerHTML; // стоимость товара
	if(cartData.hasOwnProperty(itemId)){ // если такой товар уже в корзине, то добавляем +1 к его количеству
		cartData[itemId][2] += 1;
	} else { // если товара в корзине еще нет, то добавляем в объект
		cartData[itemId] = [itemTitle, itemPrice, 1, itemImage];//itemImage,
	}

        
        var cartPrice=0;
        var cartCount=0;
        for(var items in cartData){
            cartPrice+=cartData[items][1]*cartData[items][2];
            cartCount+=cartData[items][2];
        }
        document.getElementById('cartno').innerHTML=cartCount;
        document.getElementById('cartsum').innerHTML=cartPrice;
	// Обновляем данные в LocalStorage
	if(!setCartData(cartData)){ 
		this.disabled = false; // разблокируем кнопку после обновления LS
                cartCont.style.display='block';
		cartCont.innerHTML = 'Товар добавлен в корзину.';
		setTimeout(function(){
			cartCont.innerHTML = 'Продолжить покупки...';
		}, 1000);
	}
	return false;
}
// Устанавливаем обработчик события на каждую кнопку &quot;Добавить в корзину&quot;

// Открываем корзину со списком добавленных товаров
function openCart(e){
	
	var cartData = getCartData(), // вытаскиваем все данные корзины
			totalItems = '';
	//console.log(JSON.stringify(cartData));
        cartCont.style.display='block';
	// если что-то в корзине уже есть, начинаем формировать данные для вывода
	if(cartData !== null){
		totalItems = '<table id="shopping_list" class="shopping_list"><tr><th>Наименование</th><th>Цена</th><th>Кол-во</th><th>Изображение</th></tr>';
		for(var items in cartData){
                    //console.log(items);
			totalItems += '<tr>';
                        totalItems += '<td>' + cartData[items][0] + '</td>';
                        totalItems += '<td><input id="price'+items+'" class="cart" type=text name="price['+items+']" value=' + cartData[items][1] + ' readonly></td>';
                        totalItems += '<td><input id="amount'+items+'" class="cart amount" type=number min="0" name="amount['+items+']" value=' + cartData[items][2] + '></td>';
                        totalItems += '<td><input type=hidden name="product_id[]" value="'+items+'"><img src="' + cartData[items][3] + '"/></td>';

			totalItems += '</tr>';
		}
                
		totalItems += '<tr><td>Total:</td><td><span id="cartPrice">'+cartPrice+'</span></td><td><span id="cartCount">'+cartCount+'</span></td><td></td></tr><table><a href="/order" class=button>Перейти к оформлению</a>';
		cartCont.innerHTML = totalItems;
                amounts=document.getElementsByClassName('amount');
                let total=cartPrice;
                let amount=cartCount;
                for (var i = 0; i < amounts.length; i++) {
                    amounts[i].addEventListener("change", function () {
                        id=this.id;
                        id=id.substr(6);
                        item_amount=this.value;
                        total=countPrice();
                        amount=countAmount();
                        editCart(id,item_amount);

                        document.getElementById('cartPrice').innerHTML=total;
                        document.getElementById('cartCount').innerHTML=amount;
                        document.getElementById('cartno').innerHTML=amount;
                        document.getElementById('cartsum').innerHTML=total;
                    });
                }
                total=countPrice();
                amount=countAmount();
                document.getElementById('cartPrice').innerHTML=total;
                document.getElementById('cartCount').innerHTML=amount;
	} else {
		// если в корзине пусто, то сигнализируем об этом
		cartCont.innerHTML = 'В корзине пусто!';
	}
	return false;
}
/* Открыть корзину */
addEvent(d.getElementById('checkout'), 'click', openCart);

/* Очистить корзину */
addEvent(d.getElementById('clear_cart'), 'click', function(e){
	localStorage.removeItem('cart');
	cartCont.innerHTML = 'Корзина очишена.';	
});
function countPrice(){
    amounts=document.getElementsByClassName('amount');
    let itotal=0;
    for (var i = 0; i < amounts.length; i++) {
        id=amounts[i].id;
        id=id.substr(6);
        price=document.getElementById('price'+id);
        itotal+=price.value*amounts[i].value;

    }
    //console.log('itotal',itotal);
    return itotal;
}
function countAmount(){
    amounts=document.getElementsByClassName('amount');
    let amount=0;
    for (var i = 0; i < amounts.length; i++) {
        amount+=parseInt(amounts[i].value);
    }
    return amount;
}
};