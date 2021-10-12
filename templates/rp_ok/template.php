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
              <?php load_module('rp_ok.mainmenu',0)?>
          </div>
          </div>
      </nav>
        <!-- content -->
      <div class="content">
          <div class="content-bg">
            <!-- 1 -->
          <div class="main-screen">
                  <div class="container">
                      <div class="main-screen-images"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/two.png" alt=""></div>
                      <div class="row">
                          <div class="col-lg-8 col-md-12">
                              <div class="main-screen-text">
                                  <?php echo get_moduletext('slogan')?>
                              </div>
                          </div>
                          <div class="col-lg-4 col-md-12 alignment">
                              <div class="main-screen-button">
                                  <a class="btn-primary shadow" href="category.html">каталог продукции</a>
                              </div>
                          </div>
                      </div>
                  </div>
          </div>
            <!-- 2 -->
          <div class="catalog-category">
                  <div class="container">
                      <h2>Наша продукция</h2>
                      <div class="row">
                          <div class="col-lg-4 col-md-6 col-sm-12">
                              <div class="card">
                                  <a href="">
                                  <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/demo.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                  <h5 class="card-title">Оградки</h5>
                                  </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-12">
                              <div class="card">
                                  <a href="">
                                  <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/demo.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                  <h5 class="card-title">Спец. Оградки</h5>
                                  </div>
                                  </a>
                                </div>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-12">
                              <div class="card">
                                  <a href="">
                                  <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/demo.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                  <h5 class="card-title">Акции</h5>
                                  </div>
                                  </a>
                                </div>
                          </div>
                      </div>
                  </div>
             </div>
            <!-- 3 -->
          <div class="advantages">
                  <div class="container">
                                            <?php echo get_moduletext('advantages')?>
                  </div>
          </div>
                    <!-- 4 -->
          <div class="guarantee">
              <div class="container">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="guarantee-img"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/guarant.png" alt=""></div>
                          <div class="guarantee-text">5 лет</div>
                      </div>
                      <div class="col-md-8">
                          <?php echo get_moduletext('warranties')?>
                      </div>
                  </div>
              </div>
          </div>
            <!-- 5 -->
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
            <!-- 6 -->
          <div class="description">
                  <div class="container">
                      <?php echo get_moduletext('appeal')?>
                  </div>
          </div>
            <!-- 7 -->
          <div class="delivery">
                  <div class="container">
                      <h2>Доставка</h2>
                      <div class="row alignment">
                          <div class="col-lg-6 col-md-12 col-sm-12">
                              <div class="delivery-img">
                                  <div class="delivery-img-cars">
                                      <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/cars.png" alt="">
                                  </div>
                                  <div class="delivery-img-maps">
                                      <img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/maps.png" alt="">
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-12 col-sm-12">
                              <div class="delivery-text">
                                  <?php echo get_moduletext('delivery')?>
                              </div>
                          </div>
                      </div>
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
                          <?php load_module('rp_ok.bottommenu',0)?>
                      </div>
                  </div>
                  <div class="col-lg-2">
                      <div class="footer-catalog">
                          <h4>Каталог</h4>
                          <?php load_module('rp_ok.bottomcatmenu',0)?>
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