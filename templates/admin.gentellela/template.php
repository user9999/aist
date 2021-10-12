<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo ($PAGE_TITLE[$DLANG])?$PAGE_TITLE[$DLANG]:''; ?> - система управления</title>

<?php
echo ($GLOBALS['CSS'])?$GLOBALS['CSS']:'';
?>
    <link rel="stylesheet" type="text/css" href="/templates/<?php echo $ADMIN_TEMPLATE ?>/style.css">
    <link rel="stylesheet" type="text/css" href="/templates/<?php echo $ADMIN_TEMPLATE ?>/upload.css">

    <script type="text/javascript" src="<?php echo $PATH ?>/inc/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo $PATH ?>/inc/ckeditor/lang/_languages.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script type="text/javascript" src="/templates/<?php echo $ADMIN_TEMPLATE ?>/script.js"></script>
    <script type="text/javascript" src="<?php echo $PATH ?>/js/jquery.inputmask.js"></script>
    <script type="text/javascript" src="<?php echo $PATH ?>/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?php echo $PATH ?>/js/jquery.inputmask.date.extensions.js"></script>
    <script>
$( document ).ready(function() {
//$("#deliver_date").inputmask("d-m-y");
$('[id^="date_"]').inputmask("d-m-y");//d-m-y
$('[id^="time_"]').inputmask("с h.s до h.s");
    $( ".clear" ).mouseover(function() {
        $(this).css('background-color', '#ccc');
    });
    $( ".clear" ).mouseout(function() {
        $(this).css('background-color', '#fff');
    });
});

</script>
<?php
echo ($GLOBALS['SCRIPT'])?$GLOBALS['SCRIPT']:'';
$link="";
$_GET['component']=($_GET['component'])?$_GET['component']:'index';
//echo $HOSTPATH."/components/".$_GET['component']."/".$_GET['component'].".php";
if(file_exists($HOSTPATH."/components/".$_GET['component']."/".$_GET['component'].".php")) {
    $link="/".$_GET['component'];
}
?>
  <!-- Bootstrap core CSS -->

  <link href="/templates/<?php echo $ADMIN_TEMPLATE ?>/css/bootstrap.min.css" rel="stylesheet">

  <link href="/templates/<?php echo $ADMIN_TEMPLATE ?>/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="/templates/<?php echo $ADMIN_TEMPLATE ?>/css/custom.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/templates/<?php echo $ADMIN_TEMPLATE ?>/css/maps/jquery-jvectormap-2.0.3.css" />
  <link href="/templates/<?php echo $ADMIN_TEMPLATE ?>/css/icheck/flat/green.css" rel="stylesheet" />
  <link href="/templates/<?php echo $ADMIN_TEMPLATE ?>/css/floatexamples.css" rel="stylesheet" type="text/css" />

  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/jquery.min.js"></script>
  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/nprogress.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

  <!--foot-->
    <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/bootstrap.min.js"></script>
  <!-- bootstrap progress js -->
  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/icheck/icheck.min.js"></script>

  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/custom.js"></script>

  <!-- pace -->
  <script src="/templates/<?php echo $ADMIN_TEMPLATE ?>/js/pace/pace.min.js"></script>
  <!-- /datepicker -->
</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo $PATH ?>/admin" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $SITE_TITLE[$DLANG] ?></span></a>
          </div>
          <div class="clearfix"></div>



          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
                            <?php load_module('gentellela',1)?>
            </div>
            

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a href='/admin/?component=development' data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a href='/admin/?component=logout' data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/img.jpg" alt="">John Doe
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="javascript:;">  Profile</a>
                  </li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:;">Help</a>
                  </li>
                  <li><a href="/admin/component=logout"><i class="fa fa-sign-out pull-right"></i> Выйти</a>
                  </li>
                </ul>
              </li>

              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <div class="text-center">
                      <a href="inbox.html">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main">

        <!-- top tiles -->
        <?php echo $PAGE_BODY ?>
        <!-- footer content -->

        <footer>
          <div class="copyright-info">
            <p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>  
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
      <!-- /page content -->

    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>


  <!-- /footer content -->
</body>

</html>
