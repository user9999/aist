<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 

if($_POST['settings']) {
    $percset="\$PERCENTS=array(";
    foreach($_POST['per'] as $num=>$val){
        if($val!="" && $_POST['sum'][$num]!="") {
            $percset.="\"".$_POST['sum'][$num]."\"=>\"$val\",";
        }
    }
    $percset=substr($percset, 0, -1).");";

    $config="<?php
  \$RESERVE=".floor($_POST['reserv']).";
  $percset
  ?>";
  
    $fp=fopen("inc/users.configuration.php", "w+");
    fwrite($fp, $config);
    fclose($fp);
}
if(file_exists("inc/users.configuration.php")) {
    include_once "inc/users.configuration.php";
}
$i=0;
if($GLOBALS['PERCENTS']) {
    $i=0;
    $percs="";
    foreach($PERCENTS as $sum=>$perc){

        $percs.="<tr><td width=\"120\" style=\"text-align:center;right\"><input class=\"textbox\" name=\"sum[$i]\" type=\"text\" size=\"20\" value=\"$sum\"></td><td><input class=\"textbox\" name=\"per[$i]\" type=\"text\" size=\"20\" value=\"$perc\">%</td></tr>";

        $i++;
    }
}
?>
<script src="/inc/jquery_min.js" type="text/javascript" charset="utf-8"></script>
<script>
function addInput() {
    var id = document.getElementById("default-id").value;
  id++;
  $("table[id=settins]").append('<tr id="tr-' + id + '"><td><input name="sum[' + id + ']" id="input1-' + id + '" value=""></td><td><input name="per[' + id + ']" id="input-' + id + '" value="' + (id+<?php echo $i?>) + '">% <a class="nobord" href="javascript:{}" onclick="removeInput(\'' + id + '\')"><img class="nobord" src="/img/del.gif" /></a></td></tr>');
  document.getElementById("default-id").value = id;
}

function removeInput(id) {
    $("#tr-" + id).remove();
}
</script>

<br /><br />
<form name="testform"  method="post">
<input type="hidden" id="default-id" value="<?php echo $i?>">
    <table id="settins">
        <tr>
            <td width="120" style="text-align:center;right">Время бронирования(целое число):</td><td><input class="textbox" name="reserv" type="text" size="2" value="<?php echo $GLOBALS['RESERVE']?>">час</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;background:#ddd"><b>Скидки</b></td>
        </tr>
         <tr>
            <td width="120" style="text-align:center;right">Сумма</td><td>Процент</td>
        </tr>
<?php 
if(!$GLOBALS['PERCENTS']) {
    ?>
        <tr>
            <td width="120" style="text-align:center;right"><input class="textbox" name="sum[0]" type="text" size="20" value="<?php echo $sum1?>"></td><td><input class="textbox" name="per[0]" type="text" size="20" value="1">%</td>
        </tr>
         
    <?php 
} else {
    echo $percs;
}
?>

    </table><div style="width:331px">
    <a class="nobord" href="javascript:{}" onclick="addInput()"><img class="nobord" src="/templates/blank/img/dob.jpg" /></a>
    <input  type="submit" name="settings" class="button" value="Сохранить"></div>
</form>
