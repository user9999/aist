<body>

<div id="cityoverlay">
    <div class="popup">
        <h4>Здравствуйте! РДС Медиа уже в Вашем городе!</h4>
        <p>
            Ваш город?  <a id=mycity href="/"><?=$city ?> </a> <span class=close1 id=mycity1>OK</span>
         </p>
         
         <select class=city id=city name=city><option value=select>Выбрать другой город</option>
<?php
foreach($acities as $key=>$value){
	echo "<option value='$key'>$key</option>";
}
?>		 
		 </select>
    </div>
</div>

<body>
</html>