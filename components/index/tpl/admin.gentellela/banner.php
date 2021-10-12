<div class="x_panel">
                <div class="x_title">
                  <h2>Загрузка изображений к главной странице</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br>
                  <form  enctype="multipart/form-data"  id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Название или описание изображения <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  name="url" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="1944"><ul class="parsley-errors-list" id="parsley-id-1944"></ul>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ссылка<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text"  name="url" id="last-name"  required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="4841"><ul class="parsley-errors-list" id="parsley-id-4841"></ul>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Выбрать изображение не менее <?php echo $GLOBALS['FRIMG_WIDTH']; ?>x<?php echo $GLOBALS['FRIMG_HEIGHT']; ?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="middle-name" class="form-control col-md-7 col-xs-12" name="frm_img" type="file"  name="middle-name" data-parsley-id="4607"><ul class="parsley-errors-list" id="parsley-id-4607"></ul>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="btn btn-success"  type="submit" name="frontpg" value="Отправить">
                        <!--<input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" data-parsley-id="2635">--><ul class="parsley-errors-list" id="parsley-id-2635"></ul>
                      </div>
                    </div>
                    <div class="ln_solid"></div>


                  </form>
                </div>
              </div>