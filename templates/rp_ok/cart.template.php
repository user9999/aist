<!doctype html>
  <html lang="ru">
      <head>
          <!-- Meta -->
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- CSS -->
          <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/css/bootstrap.css">
          <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/css/style.css">
          <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/fonts/futura/futura.css">
          <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/css/carousel/owl.carousel.min.css">
          <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/css/carousel/owl.theme.default.min.css">
          <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/css/fancybox/jquery.fancybox.min.css">
            <title><?php echo $PAGE_TITLE ?></title>

<meta name="description" content="<?php echo $META_DESCRIPTION ?>">

<meta name="keywords" content="<?php echo $META_KEYWORDS ?>">
  <!--kvn_css-->

<!--kvn_css_user-->

<?php echo $GLOBALS['CSS'];?>

 <!--kvn_scripts-->

<!--kvn_script_user-->

<?php echo $GLOBALS['SCRIPT'];?>

</head>
  <body>
      <!-- header -->
      <header class="header-main">
          <div class="container">
              <div class="row">
                  <div class="col-md-8">
                      <div class="header-top">
                          <div class="header-top-logo">
                              <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo.png" alt="">
                          </div>
                          <div class="header-text">
                              <span class="header-text-1">Ритуальные принадлежности</span>
                              <span class="header-text-2">Изготовление оградок и памятников</span>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 alignment">
                      <div class="header-contacts">
                          <div class="header-contacts-phone">8 (800) 500-44-55</div>
                          <div class="header-contacts-text">Звонок по России бесплтаный</div>
                          <div class="header-contacts-mail">info@irkimz.ru</div>
                      </div>
                  </div>
              </div>
          </div>
      </header>
        <!-- menu -->
      <nav class="navbar navbar-expand-xl header-menu navbar-light">
          <div class="container">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-navbar" aria-controls="header-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="header-navbar">
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="category.html">Каталог</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="page.html">Гарантии</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#">Акции</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#">О нас</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#">Доставка</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#">Контакты</a>
                  </li>
                  <li class="nav-item">
                      <a href=""><i class="fas fa-shopping-cart"></i></a>
                  </li>
                  <li class="nav-item">
                      <a href=""><i class="far fa-heart"></i></a>
                  </li>
              </ul>
          </div>
          </div>
      </nav>
        <!-- content -->
      <div class="content">
          <div class="content-bg">
                <!-- breadcrumb -->
              <nav class="breadcrumb-top" aria-label="breadcrumb">
              <div class="container">
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Главная</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Корзина</li>
                  </ol>
              </div>
          </nav>
                        <!-- 1 -->
          <div class="cart">
              <div class="container">
                    <div class="row cart-title">
                      <div class="col-lg-3 col-sm-3 col-xs-12">
                          <div class="cart-text">Изображение</div>
                      </div>
                      <div class="col-lg-4 col-sm-3 col-xs-12 mob-fix">
                          <div class="cart-text">Наименование</div>
                      </div>
                      <div class="col-lg-2 col-sm-2 col-xs-12 mob-fix">
                          <div class="cart-text">Цена</div>
                      </div>
                      <div class="col-lg-2 col-sm-2 col-xs-12 mob-fix">
                          <div class="cart-text">Количество</div>
                      </div>
                      <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix">
                          <div class="cart-text">Удалить</div>
                      </div>
                           </div>
                  <div class="row cart-product-list">
                      <div class="cart-img col-lg-3 col-sm-3 col-xs-12">
                          <img  src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/demo.png"/>
                      </div>
                      <div class="col-lg-4 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">                          Оградка МТ-12                      </div>
                      <div class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">                          15 200₽                      </div>
                      <div class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">                          1                      </div>
                      <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                          <i class="fas fa-times"></i>
                      </div>
                  </div>
                  <div class="row cart-product-list">
                      <div class="cart-img col-lg-3 col-sm-3 col-xs-12">
                          <img  src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/demo.png"/>
                      </div>
                      <div class="col-lg-4 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">                          Оградка МТ-12                      </div>
                      <div class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">                          15 200₽                      </div>
                      <div class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">                          1                      </div>
                      <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                          <i class="fas fa-times"></i>
                      </div>
                  </div>
                  <div class="cart-hr"></div>
                    <div class="row alignment">
                      <div class="col-lg-6 col-md-12 col-sm-12">
                          <div class="cart-cupon">
                              <form>
                                  <input type="text" class="form-control" placeholder="Введиет код купона">
                              </form>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-12 col-sm-12">
                          <div class="cart-btn">
                              <div class="cart-price">Доставка: <span>3000₽</span></div>
                              <div class="cart-price">Скидка купона: <span>13000₽</span></div>
                              <div class="cart-price indent">Общая стоимость: <span>35000₽</span></div>
                              <a class="btn-favorites" href="#">В каталог</a>
                              <a class="btn-btn" href="#" data-toggle="modal" data-target="#checkout">Оформить заказ</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
                    </div>
      </div>
      <!-- /content -->
        <!-- Modal -->
    <div class="modal fade" id="checkout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Оформить заказ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="checkout-total">Ваша сумма заказа: <span>35000₽</span><br>              При оплате онлайн вы получите дополнительную скидку 5%!</div>
              <form class="checkout-label">
                  <div class="form-group">
                      <label for="">Ваше имя</label>
                      <input type="email" class="form-control" id="" placeholder="Екатерина">
                  </div>
                  <div class="form-group">
                      <label for="">Ваше Email</label>
                      <input type="email" class="form-control" id="" placeholder="ekaterina@mail.ru">
                  </div>
                  <div class="form-group">
                      <label for="">Ваше номер телефона</label>
                      <input type="email" class="form-control" id="" placeholder="+79995005555">
                  </div>
                  <div class="form-group">
                      <label for="">Способ оплаты</label>
                      <div class="custom-control custom-radio">
                                           <input type="radio" id="ch1" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="ch1">Оплата онлайн (без комиссий)</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="ch2" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="ch2">Оплата через банк</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="ch3" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="ch3">Оплата при наличии</label>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="">Способ Доставки</label>
                      <div class="custom-control custom-radio">
                                           <input type="radio" id="ch4" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="ch4">Транспортной компанией</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="ch5" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="ch5">Курьером</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="ch6" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="ch6">Самовывоз</label>
                      </div>
                  </div>
                  <div class="form-group">
                  <label class="form-check-label" for="invalidCheck">Я согласен на обработку персональных данных</label>
                  </div>
                  <a class="btn-btn" href="#">Отправить данные</a>
                                  </form>
            </div>
        </div>
      </div>
    </div>
          <!-- footer -->
      <footer>
          <div class="container">
              <div class="row">
                  <div class="col-lg-3">
                      <div class="footer-logo">
                          <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo.png" alt="">
                      </div>
                  </div>
                  <div class="col-lg-2">
                      <div class="footer-menu">
                          <h4>Меню</h4>
                          <ul>
                              <li><a href="">Главная</a></li>
                              <li><a href="">Каталог</a></li>
                              <li><a href="">Гарантии</a></li>
                              <li><a href="">Акции</a></li>
                              <li><a href="">О нас</a></li>
                              <li><a href="">Доставка</a></li>
                              <li><a href="">Контакты</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-lg-2">
                      <div class="footer-catalog">
                          <h4>Каталог</h4>
                          <ul>
                              <li><a href="">Оградки</a></li>
                              <li><a href="">Памятники</a></li>
                              <li><a href="">Столы</a></li>
                              <li><a href="">Скамейки</a></li>
                              <li><a href="">Спец. оградки</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-lg-5">
                      <div class="footer-info">
                          <h4>Иркутский металлообрабатывающий завод</h4>
                          <p>ООО "СпецТехМаш"<br>                          Иркутск, улица Рабочего Штаба 78/1</p>
                          <p>+7 (3952) 40-72-39<br>                          E-mail: info@irkimz.ru</p>
                      </div>
                                        </div>
              </div>
          </div>
      </footer>
        <!-- JS -->
      <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/js/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/08bf94ce22.js" crossorigin="anonymous"></script>
      <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/js/carousel/owl.carousel.min.js"></script>
      <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/js/carousel/setting.js"></script>
      <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/assets/js/fancybox/jquery.fancybox.min.js"></script>
      <!--kvn_widgets-->

</body>
  </html>