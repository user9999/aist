<div class=left_menu>
<h4>Фильтр товаров</h4>
<div class=menu1>
<h3>Бренды</h3>
<ul>
<?php
//var_dump($TEMPLATE['segments']);
//htmldump($TEMPLATE['current'],'brands');
if($TEMPLATE['brands']) {
    if(!$TEMPLATE['segments'][3]) {
        ?>
<li><a style="background:url(/images/checked.png) no-repeat top left" href="/catalog/<?php echo $TEMPLATE['section']; ?>/<?php echo $TEMPLATE['subsection']; ?>">Любой</a></li>
    
        <?php	
    } else {
        ?>
<li><a style="background:url(/images/unchecked.png) no-repeat top left" href="/catalog/<?php echo $TEMPLATE['section']; ?>/<?php echo $TEMPLATE['subsection']; ?>">Любой</a></li>
    
        <?php	
    }

    foreach($TEMPLATE['brands'] as $brand){
        if(strtolower($brand)==strtolower($TEMPLATE['current'])) {
            ?>
<li><a style="background:url(/images/checked.png) no-repeat top left" href="/catalog/<?php echo $TEMPLATE['section']; ?>/<?php echo $TEMPLATE['subsection']; ?>/<?php echo urlencode($brand); ?>"><?php echo $brand; ?></a></li>
    
            <?php
            //strtolower($brand);
        } else {
            ?>
<li><a style="background:url(/images/unchecked.png) no-repeat top left" href="/catalog/<?php echo $TEMPLATE['section']; ?>/<?php echo $TEMPLATE['subsection']; ?>/<?php echo urlencode($brand); ?>"><?php echo $brand; ?></a></li>

            <?php
        }
    }
}
?>
</div>
<?php
$sortby=unserialize($TEMPLATE['sortby']);
if($sortby) {
    //arsort($sortby);
    foreach($sortby as $num=>$name){
        ?>
<div id="sort<?php echo $num ?>" class=sort>
<h3><?php echo $name ?></h3>
<ul>
        <?php
        foreach($TEMPLATE['sort'][$num] as $cnum=>$value){

            if(!$TEMPLATE['sort'][$num]['stat']) {
                $style=($_GET['c'][$num]=='all' || !$_GET['c'][$num])?'style="background:url(/images/checked.png) no-repeat top left"':'style="background:url(/images/unchecked.png) no-repeat top left"';


                ?>
<li><a <?php echo $style ?> href="/<?php echo makeurl(); ?>?<?php echo makeget($num, 'all'); ?>">Любой</a></li>
                <?php
                $TEMPLATE['sort'][$num]['stat']=1;
            }
            if($value) {
                //echo $_GET['c'][$num];
                $style=($value==$_GET['c'][$num])?'style="background:url(/images/checked.png) no-repeat top left"':'style="background:url(/images/unchecked.png) no-repeat top left"';

                //$style=($value==$_GET['c'][$num])?'style="background:url(/images/checked.png) no-repeat top left"':'style="background:url(/images/unchecked.png) no-repeat top left"';
                ?>
<li><a <?php echo $style ?> href="/<?php echo makeurl(); ?>?<?php echo makeget($num, $value); ?>"><?php echo $value; ?></a></li>

                <?php
            }
        }
        ?>
</ul>




</div>
        <?php
    }
}
?>
</div>
