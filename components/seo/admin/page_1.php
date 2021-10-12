<?php
require_once("page.class.php");
//require
$page=new page;
require_once "dbquery.class.php";
$display=new dbquery;
switch($_REQUEST['action']){
	case "add":
		$display->add_user();
		break;
	case "update":
		$display->update_user();
		$target['<!--results-->']=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='del[<!--id-->]' value='Удалить' /><input type='submit' name='edit[<!--id-->]' value='Редактировать' /></td></tr>\r\n");
		$newact="display";
		break;
	case "del":
		if($_POST['del']){
			$display->del_user();
			$target['<!--results-->']=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='del[<!--id-->]' value='Удалить' /><input type='submit' name='edit[<!--id-->]' value='Редактировать' /></td></tr>\r\n");
		}else if($_POST['edit']){
			$target=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='del[<!--id-->]' value='Удалить' /><input type='submit' name='edit[<!--id-->]' value='Редактировать' /></td></tr>\r\n",$_POST['edit'],"edit");
			$newact="update";
		}
		break;
	case "search":
		$target['<!--results-->']=$display->search_user();
		break;
	default:
		$target['<!--results-->']=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='del[<!--id-->]' value='Удалить' /><input type='submit' name='edit[<!--id-->]' value='Редактировать' /></td></tr>\r\n");
		break;
}
$act=($newact)?$newact:$_GET['act'];
switch ($act){
	case "search":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"search\" />";
		$aspage="admin/searchpage_1";
		break;
	case "display":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"display\" />";
		$aspage="admin/showpage_1";
		break;
	case "del":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"display\" />";
		$aspage="admin/showpage_1";
		break;
	case "add":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"add\" />";
		$aspage="admin/addpage_1";
		break;
	case "update":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"update\" /><input type=\"hidden\" name=\"id\" value=\"".$target['--id--']."\" />";
		$aspage="admin/addpage_1";
		break;
	default:
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"display\" />";
		$aspage="admin/showpage_1";
		break;
}
//target


$target['<!--title-->']="";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="";
$cont=$page->replace_file("admin/index.tpl","admin/menu,content#".$aspage,$target);
print $cont;
?>