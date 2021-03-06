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
                      <a class="nav-link" href="category.html">Каталог</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="page.html">Гарантии</a>
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
                  <li class="breadcrumb-item active" aria-current="page">Гарантии</li>
                  </ol>
              </div>
          </nav>
            <!-- 1 -->
          <div class="page">
                  <div class="container">
                      <div class="row">
                          <div class="col-lg-3 col-md-12 col-sm-12">
                              <div class="sidebar">
                                  <div class="sidebar-block">
                                      <div class="sidebar-title"><h2>Каталог продукции</h2></div>
                                      <div class="sidebar-category">
                                          <?php load_module('rp_ok.catalogmenu',0)?>
                                      </div>
                                  </div>
                                  <div class="sidebar-block">
                                      <div class="sidebar-title"><h2>Акции и скидки</h2></div>
                                      <div class="sidebar-action">
                                          <div class="card">
                                              <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/demo.png" class="card-img-top" alt="...">
                                              <div class="card-body">
                                                  <h5 class="card-title">МТ-12</h5>
                                                  <p class="action-price"><span class="transform">Цена:</span> 1000₽/м <span class="action-oldprice">2000₽/м</span></p>
                                                  <p class="card-text">За 1 м/п (метр погонный)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-8 col-md-12 col-sm-12">
                              <div class="main">
                                  <p class="introduction">                                      Это простая текстовая страница<br>Здесь и на других подобных страницах будет текст, который напишет копирайтер                                  </p>
                              </div>
                          </div>
                      </div>
                  </div>
          </div>
            <!-- 2 -->
          <div class="guarantee">
              <div class="container">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="guarantee-img"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/guarant.png" alt=""></div>
                          <div class="guarantee-text">5 лет</div>
                      </div>
                      <div class="col-md-8">
                          <div class="guarantee-title"><h3>Предоставляем гарантии</h3></div>
                          <div class="guarantee-description">Иркутский Металлообрабатывающий Завод предоставляет гарантию на изготовленную продукцию.                               Пройдите в раздел <a href="">ГАРАНТИИ</a>, чтобы ознакомиться с сертификатами качества и сроками гарантии на конкретные виды изделий.</div>
                      </div>
                  </div>
              </div>
          </div>
            <!-- 3 -->
          <div class="consultation">
                  <div class="container">
                      <h2>Консультация</h2>
                      <p>Оставьте Ваше сообщение и контактные данные и наши специалисты свяжутся с Вами в ближайшее рабочее время для решения Вашего вопроса.</p>
                      <form>
                          <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-12">
                                  <label for="">Ваше имя</label>
                                  <input type="text" class="form-control" placeholder="Анастасия">
                              </div>
                              <div class="col-lg-4 col-md-6 col-sm-12">
                                  <label for="">E-mail</label>
                                  <input type="text" class="form-control" placeholder="mail@mail.ru">
                              </div>
                              <div class="col-lg-4 col-md-6 col-sm-12">
                                  <label for="">Телефон</label>
                                  <input type="text" class="form-control" placeholder="8 800 800 80 80">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-lg-8 col-md-12 col-sm-12">
                                  <label for="">Сообщение</label>
                                  <textarea class="form-control" rows="4" placeholder="Необязательно"></textarea>
                              </div>
                              <div class="col-lg-4 col-md-12 col-sm-12 alignment">
                                  <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                                      <label>Нажимая на кнопку ниже, я даю согласие <a href="">на обработку своих персональных данных.</a></label>
                                    </div>
                                    <a class="btn-primary shadow" href="#">Получить Консультацию</a>
                              </div>
                          </div>
                      </form>
                  </div>
          </div>
                                </div>
      </div>
      <!-- /content -->
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