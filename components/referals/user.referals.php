<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if (isset($_SESSION['email'])) {
    $rows="<script>
	var stat = new Array()
	var stat1 = new Array()
	\$( document ).ready(function() {
    \$( \".row\" ).click(function() {
		urow = \$( this );
		ulevel=urow.attr( \"class\" );
		uid=urow.attr( \"id\" );
		newid=uid.replace(/user/g,\"\");
		
		if(stat[newid]==1){
//прячем
$( \"#refer\"+newid ).hide( \"fast\" );
stat[newid]=2;
}else if(stat[newid]==2){
//показываем
$( \"#refer\"+newid ).show( \"fast\" );
stat[newid]=1;
} else {
//подгружаем
		//alert($(this).closest(\".level1\").attr(\"id\"));
		wait=\"<div class='level1' style='text-align:center'><div class=wait><img src='/img/wait.gif'></div></div>\";
		\$( \"#refer\"+newid ).html( wait );
		\$( \"#refer\"+newid ).show( \"fast\" );
		\$.ajax({
  type: \"POST\",
  url: \"/ajax/referals.php\",
  data: { user: uid,level:ulevel}
})
  .done(function( msg ) {
	//newid=uid.replace(/user/g,\"\")
    \$( \"#refer\"+newid ).html( msg );
	\$( \"#refer\"+newid ).show( \"fast\" );
  });
stat[newid]=1;
}
		
		

		
		
		

	});
	$('body').on('click', '.row', function () {
		urow = \$( this );
		ulevel=urow.attr( \"class\" );
		uid=urow.attr( \"id\" );
		newid=uid.replace(/user/g,\"\");
///begin		
	if(stat1[newid]==1){
//прячем
$( \"#refer\"+newid ).hide( \"fast\" );
stat1[newid]=2;
}else if(stat[newid]==2){
//показываем
$( \"#refer\"+newid ).show( \"fast\" );
stat1[newid]=1;
} else {
//подгружаем
		//alert($(this).closest(\".level1\").attr(\"id\"));
		wait=\"<div class=\'level1'><div class=noref><img src='/img/wait.gif'></div></div>\";
		\$( \"#refer\"+newid ).html( wait );
		\$( \"#refer\"+newid ).show( \"fast\" );

		\$.ajax({
  type: \"POST\",
  url: \"/ajax/referals.php\",
  data: { user: uid,level:ulevel}
})
  .done(function( msg ) {
	//newid=uid.replace(/user/g,\"\")
    \$( \"#refer\"+newid ).html( msg );
	\$( \"#refer\"+newid ).show( \"fast\" );
  });
stat1[newid]=1;
}	
		

		
		
///////end		
      });
	});
</script>";
    set_script($rows);
    ?>
<table class=refup><caption>Вышестоящие партнеры</caption>
<tr class=rowtitle><td>ID</td><td>Имя</td><td>Телефон</td></tr>
    <?php
    $res=mysql_query('select level from users where id='.$_SESSION['userid'].' limit 1');
    $row=mysql_fetch_row($res);
    $level=$row[0];
    $plus=($level>=5)?1:0;
    $level=($level<=$LEVELS)?$level:$LEVELS;
    
    $level=$level+$plus;
    //echo $level."<br>";
    for($i=1;$i<=($level);$i++){
        $str[1].="u$i.id as uid$i,u$i.parent_id as parent$i,u$i.email as mail".$i.",u$i.phone as phone".$i.",u".$i.".name as name".$i.",";
        $str[2].="users as u".$i.",";
        if($i<($level)) {
            $str[3].=" and u".$i.".parent_id=u".($i+1).".id";//u1.parent_id=u2.id
        }
    }
    /*
    for($i=$level;$i>=1;$i--){
    $str[1].="u".$i.".id as l".$i.",u".$i.".email as mail".$i.",u".$i.".name as name".$i.",u".$i.".level as level".$i.",".$i.",";
    $str[2].="users as u".$i.",";
    if($i>1){
    $str[3].=" and u".$i.".parent_id=u".($i-1).".id";
    }
    }
    */
    $q="select ".substr($str[1], 0, -1)." from ".substr($str[2], 0, -1)." where u1.id={$_SESSION['userid']} ".$str[3];
    //echo $q."<br>";//die();
    $res=mysql_query($q);
    if(mysql_num_rows($res)) {
        $row=mysql_fetch_assoc($res);
    
        foreach($row as $name=>$val){
            if(strpos($name, 'uid')!==false && $name!='uid1' && $id!=$_SESSION['userid']) {
                echo "<tr><td>$id</td><td>$uname</td><td>$phone</td></tr>";
            }
            $phone=(strpos($name, 'phone')!==false)?$val:$phone;
            $id=(strpos($name, 'uid')!==false )?$val:$id;
            $uname=(strpos($name, 'name')!==false )?$val:$uname;
            //$birthdate=(strpos($name,'birthdate')!==false )?$val:$birthdate;
            //$points=(strpos($name,'points')!==false )?$val:$points;
            //$regdate=(strpos($name,'regdate')!==false )?date("d.m.Y",intval($val)):$regdate;
            //echo $name."=".$val."<br>";
        }
    
        echo "<tr><td>$id</td><td>$uname</td><td>$phone</td></tr>";
    }
    //mysql_query("select u1.parent_id as lev1,u2.parent_id as lev2,u3.parent_id as lev3, u4.parent_id as lev4 from users as u1,users as u2,users as u3,users as u4 where u1.id=".$_SESSION['userid']." and u2.parent_id=u1.id  and u2.parent_id=u1.id and u3.parent_id=u2.id and u4.parent_id=u3.id ");
    //"select u1.parent_id as lev1,u2.parent_id as lev2,u3.parent_id as lev3, u4.parent_id as lev4 from users as u1,users as u2,users as u3,users as u4 where u1.id=28 and u1.parent_id=u2.id  and u2.parent_id=u3.id and u3.parent_id=u4.id"
    //mysql_query("select * from users where id=parent_id");
    ?>
</table>
    <?php

    echo "<div class=\"level1 row title\"><h3>Ваши партнеры</h3></div><div class=\"level1 rowtitle\"><div class=invites title='номер договора'>ID</div> <div class=level title='уровень'>Линия</div><div class=names>Имя</div> <div class=phones>Телефон</div> <div class=births> Дата рождения </div> <div class=amountrefs>Кол-во<br>партнеров </div> <div class=allpoints>Рублей</div><div class=regdate>Дата регистрации</div></div>";
    $res=mysql_query("select * from users where parent_id=".$_SESSION['userid']);
    if(mysql_num_rows($res)) {
        $r=1;
        while($row=mysql_fetch_array($res)){
            $rn=($r%2==0)?2:"";// class=\"level1 row".$rn."\" 
            $refsum=$row['ref_amount']+$row['ref2_amount']+$row['ref3_amount']+$row['ref4_amount'];
            echo "<div class=\"level1 row\" id=user".$row['id']."> <div class=invites>".$row['id']."</div><div class=level>1</div><div class=names>".$row['name']."</div> <div class=phones>".$row['phone']."</div> <div class=births> ".$row['birthdate']." </div> <div class=amountrefs>".$refsum." (".$row['ref_amount'].",".$row['ref2_amount'].",".$row['ref3_amount'].",".$row['ref4_amount'].")</div> <div class=allpoints>".$row['points']."</div><div class=regdate>".date("d.m.Y", $row['regdate'])."</div></div><div class=level2 id=refer".$row['id']." style=\"display:none\"></div>";
            $r++;
        }
    } else {
        echo "<div class=norefs>Партнеров не найдено</div>";
    }
} else {
    header("Location:/error");
}
?>
