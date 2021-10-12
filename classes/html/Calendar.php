<?php
class Calendar
{
	public function __construct()
	{
		
	}
	public function makeCalendar($active,$name,$class)
    {
  	  //$class=($class!="")?" class='{$class}'":"";
  	  $calendar="<input name='{$name}' id='{$name}' class='new_date {$class}' type='text' value='{$active}' data-date-format='DD-MM-YYYY'>";
  	  echo $calendar;
    }
}