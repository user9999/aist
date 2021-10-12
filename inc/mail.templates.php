<?php
$mailtemplates=array (
  'congratulation' => 
  array (
    0 => 'Поздравление от {:sitetitle:}',
    1 => '<p>
	{:username:}</p>
<p>
	&nbsp;</p>
<p>
	Администрация {:sitetitle:}</p>
',
  ),
  'test' => 
  array (
    0 => 'Проверка от {:sitetitle:}',
    1 => '<p>
	<strong>Уважаемый</strong> {:username:}&nbsp;&nbsp; (id={:userid:} )</p>
<p>
	Новый пароль: {:password:}</p>
<p>
	Проверьте данные</p>
<p>
	{:userdata:}</p>
<p>
	Почтовый ящик {:usermail:}</p>
<p>
	Акции: {:actions:}</p>
<p>
	&nbsp;&nbsp;<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Администрация&nbsp;&nbsp; </strong>{:sitetitle:}&nbsp;&nbsp; {:url:}</p>
',
  ),
);
?>