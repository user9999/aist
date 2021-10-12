<?php
if($TEMPLATE['message']){
    echo $TEMPLATE['message'];
}
?>
<div id="wrapper">


    <p> <button id="clear_cart">Очистить корзину</button></p>
    <form method="post" action="/order">
       
        <div  id="cart_content">
            
    <table id="shopping_list" class="shopping_list"></table>
    
    Имя <input type="text" name="name" value="" required=""><br>
    Телефон <input type="text" name="phone" value="" required=""><br>
    Адрес <input type="text" name="address" value="" required=""><br>
    Email <input type="text" name="email" value=""><br>
            <input type="submit" value="Заказать">
        </div>
    </form>
</div>


