<?php
$component=$TEMPLATE['component_title'];
?>
<fieldset><legend><?=$TEMPLATE['component_title']?></legend>
<?php
foreach ($TEMPLATE as $action=>$value) {
    if ($action!='component_title' and $action!='checked') {

       //var_dump($TEMPLATE['checked']->$component->$action); ?>
    <label for="<?=$TEMPLATE['component_title']?>_<?=$action?>"><?=($value)?$value:$action; ?> <input id="<?=$TEMPLATE['component_title']?>_<?=$action?>" class="mainform admin_users" type=checkbox name="roles[<?=$TEMPLATE['component_title']?>][<?=$action?>]" value='1' <?=($TEMPLATE['checked']->$component->$action)?'checked':''; ?>></label><br>
    
<?php
    }
}
?>
</fieldset>

