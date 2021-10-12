<?php
class upload{
	private $mess="";
	function up(){
		if($_FILES['userfile']['size']>(50*1024)){
			$this->mess.="- вес файла больше 50 килобайт<br />";
		}
		if($_FILES['userfile']['type']!="image/jpg" && $_FILES['userfile']['type']!="image/jpeg"){
  			$this->mess.="- загружать можно только фотки<br />";
		}
		if($_FILES['userfile']['error']!=0){
			if($_FILES['userfile']['error']<3){
				$this->mess.="- Размер принятого файла превысил максимально допустимый размер<br />";
			}
        		if($_FILES['userfile']['error']==3){$this->mess."- Загружаемый файл был получен только частично!<br />";}
        		if($_FILES['userfile']['error']==4){$this->mess."- Файл не был загружен<br />";}
			return $this->mess;
		}
		if($this->mess==""){
			$ext=substr($_FILES['userfile']['name'],strrpos($_FILES['userfile']['name'],"."));
			if(file_exists("userfiles/".$_SESSION['id']."/tpl".$ext)){
				unlink("userfiles/".$_SESSION['id']."/tpl".$ext);
			}
			if (move_uploaded_file($_FILES['userfile']['tmp_name'],"userfiles/".$_SESSION['id']."/tpl".$ext)){
				$result=2;
			} else {
				$result="Неудалось загрузить файл";
			}
		} else {
			return $this->mess;
		}
		return $result;
	}
}
?>