<?php
class upload{
	private $mess="";
	function up(){
		if($_FILES['userfile']['size']>(50*1024)){
			$this->mess.="- ��� ����� ������ 50 ��������<br />";
		}
		if($_FILES['userfile']['type']!="image/jpg" && $_FILES['userfile']['type']!="image/jpeg"){
  			$this->mess.="- ��������� ����� ������ �����<br />";
		}
		if($_FILES['userfile']['error']!=0){
			if($_FILES['userfile']['error']<3){
				$this->mess.="- ������ ��������� ����� �������� ����������� ���������� ������<br />";
			}
        		if($_FILES['userfile']['error']==3){$this->mess."- ����������� ���� ��� ������� ������ ��������!<br />";}
        		if($_FILES['userfile']['error']==4){$this->mess."- ���� �� ��� ��������<br />";}
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
				$result="��������� ��������� ����";
			}
		} else {
			return $this->mess;
		}
		return $result;
	}
}
?>