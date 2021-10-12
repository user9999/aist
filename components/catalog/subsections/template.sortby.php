<?php
if($TEMPLATE['sort']) {
    ?>
<div class="sortby">
<form method=get>
    <?php
    $i=1;
    foreach($TEMPLATE['sort'] as $name=>$values){
        echo "<div class=sorts>$name</div><select class=sortvalues name=c[$i]><option value=all>Все</option>\n";
        foreach($values as $n=>$v){
            //echo "vvv ".$_GET['c'][$i]." -++--";
            $selected=($_GET['c'][$i]==urldecode($v))? "selected":"";
            echo "<option value='{$v}' $selected>$v</option>";
        }
        $i++;
        echo "</select>\n";
    }
    ?>
</form>
</div>
    <?php
}
?>
<script>
$('.sortvalues').change(
    function(){
    
         $(this).closest('form').trigger('submit');
         /* or:
         $('#formElementId').trigger('submit');
            or:
         $('#formElementId').submit();
         */
    });
</script>
