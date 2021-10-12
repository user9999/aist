<div id="slider_index" class="carousel slide" data-ride="carousel">
<div class="carousel-inner">
<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
$res=mysql_query("SELECT * FROM ".$PREFIX."frontpage where display=1 and type='image' order by position");
if (mysql_num_rows($res)==0) {
} else {
    ?>

<div class="main-slider-wrapp">
    <div class="main-slider">
    <?php
    while ($row=mysql_fetch_assoc($res)) {
    ?>    
        <div class="carousel-item active">
            <div class="images" style="background-image: url('/uploaded/front/<?php echo $row['name'] ?>');">
                <div class="overlay">
                <div class="carousel-caption">
                    <h3><?php echo $row['title'] ?></h3>
                    <p><?php echo $row['description'] ?></p>
                    <a class="btn__slider" href="<?php echo $row['url'] ?>">Подробнее</a>
                </div>  
                </div>
            </div>
        </div> 
    <?php    
}
?>
        
    </div>
    <a class="carousel-control-prev" href="#slider_index" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#slider_index" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>


            



