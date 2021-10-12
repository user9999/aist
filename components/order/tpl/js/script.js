window.onload = function(e){ 
    var cartData = getCartData() || {};
    var delivery=2000;
    var mounting=3000;
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
    var cartCont = d.getElementById('shopping_list'); // блок вывода данных корзины
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


    var cartData = getCartData(), // вытаскиваем все данные корзины
			totalItems = '';
	//console.log(JSON.stringify(cartData));
        cartCont.style.display='block';
	// если что-то в корзине уже есть, начинаем формировать данные для вывода
	if(cartData !== null){
		totalItems = '<tr><th>Наименование</th><th>Цена</th><th>Кол-во</th><th>Изображение</th></tr>';
		for(var items in cartData){
                    //console.log(items);
			totalItems += '<tr>';
                        totalItems += '<td>' + cartData[items][0] + '</td>';
                        totalItems += '<td><input id="price'+items+'" class="cart" type=text name="price['+items+']" value=' + cartData[items][1] + ' readonly></td>';
                        totalItems += '<td><input id="amount'+items+'" class="cart amount" type=number min="0" name="amount['+items+']" value=' + cartData[items][2] + '></td>';
                        totalItems += '<td><input type=hidden name="product_id[]" value="'+items+'"><img src="' + cartData[items][3] + '"/></td>';

			totalItems += '</tr>';
		}
                totalItems += '<tr><td>Доставка ('+delivery+'руб.)</td><td><select class=cart id="delivery" name=delivery><option value=0>Нет</option><option value=1>Да</option></select></td><td></td><td></td></tr>';
                totalItems += '<tr><td>Сборка ('+mounting+'руб.)</td><td><select class=cart id="mounting" name=mounting><option value=0>Нет</option><option value=1>Да</option></select></td><td></span></td><td></td></tr>';
		totalItems += '<tr><td>Total:</td><td><input type=hidden id="cartPrice" name=total_price value="'+cartPrice+'"><span id="cartPriceView">'+cartPrice+'</span></td><td><span id="cartCount">'+cartCount+'</span></td><td></td></tr>';
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

                        document.getElementById('cartPrice').value=total;
                        document.getElementById('cartPriceView').innerHTML=total;
                        document.getElementById('cartCount').innerHTML=amount;
                        document.getElementById('cartno').innerHTML=amount;
                        document.getElementById('cartsum').innerHTML=total;
                    });
                }
                var del = document.getElementById('delivery');
                del.addEventListener('change', function() {
                    total=countPrice();
                    document.getElementById('cartPrice').value=total;
                    document.getElementById('cartPriceView').innerHTML=total;
                    document.getElementById('cartsum').innerHTML=total;
                    
                });
                var mount = document.getElementById('mounting');
                mount.addEventListener('change', function() {
                    total=countPrice();
                    document.getElementById('cartPrice').value=total;
                    document.getElementById('cartPriceView').innerHTML=total;
                    document.getElementById('cartsum').innerHTML=total;
                });
                total=countPrice();
                //console.log('after t',total);
                amount=countAmount();
                document.getElementById('cartPrice').value=total;
                document.getElementById('cartPriceView').innerHTML=total;
                document.getElementById('cartCount').innerHTML=amount;
	} else {
		// если в корзине пусто, то сигнализируем об этом
		cartCont.innerHTML = 'В корзине пусто!';
	}







// Устанавливаем обработчик события на каждую кнопку &quot;Добавить в корзину&quot;



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
    var del = document.getElementById('delivery');
     if(del.value=='1'){
        itotal+=delivery;
    }
    var mount = document.getElementById('mounting');
    if(mount.value=='1'){
        itotal+=mounting;
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