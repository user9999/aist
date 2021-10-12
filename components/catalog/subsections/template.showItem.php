<?php $t = array("есть", "нет", "ожидается"); 
$picbr=($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'];
$picmod=($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'];
$pictitle=$TEMPLATE['description']." ".$TEMPLATE['brand']." ".$TEMPLATE['model'];
$pictitle=str_replace("\n", "", $pictitle);
$buydesc=trim(str_replace("(метал)", "", $TEMPLATE['description']));
$alt=($TEMPLATE['alt'])?$TEMPLATE['alt']:"alt=\"".$pictitle."\"";
$mycss="<link type='text/css' href='/css/contact.css' rel='stylesheet' media='screen' />
<link type='text/css' href='/css/oneclick.css' rel='stylesheet' media='screen' />
";
set_css($mycss);
$script="<script src=\"/inc/jquery.prettyPhoto.js\" type=\"text/javascript\" charset=\"utf-8\"></script>

<!--<script type='text/javascript' src='/js/contact.js'></script>-->
";

$script.="<script type=\"text/javascript\">
jQuery(function ($) {
	var contact = {
		message: null,
		init: function () {
			$('#oneclickcard').click(function (e) {
				e.preventDefault();

				// load the contact form using ajax
				$.get(\"/data/contact.php\",{title: '{$pictitle}'}, function(data){
					// create a modal dialog with the data
					$(data).modal({
						closeHTML: \"<a href='#' title='Close' class='modal-close'>x</a>\",
						position: [\"15%\",],
						overlayId: 'contact-overlay',
						containerId: 'contact-container',
						onOpen: contact.open,
						onShow: contact.show,
						onClose: contact.close
					});
				});
			});
		},
		open: function (dialog) {
			// dynamically determine height
			var h = 280;
			if ($('#contact-subject').length) {
				h += 26;
			}
			if ($('#contact-cc').length) {
				h += 22;
			}

			var title = $('#contact-container .contact-title').html();
			$('#contact-container .contact-title').html('Loading...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container .contact-content').animate({
							height: h
						}, function () {
							$('#contact-container .contact-title').html(title);
							$('#contact-container form').fadeIn(200, function () {
								$('#contact-container #contact-name').focus();

								$('#contact-container .contact-cc').click(function () {
									var cc = $('#contact-container #contact-cc');
									cc.is(':checked') ? cc.attr('checked', '') : cc.attr('checked', 'checked');
								});
							});
						});
					});
				});
			});
		},
		show: function (dialog) {
			$('#contact-container .contact-send').click(function (e) {
				e.preventDefault();
				// validate form
				if (contact.validate()) {
					var msg = $('#contact-container .contact-message');
					msg.fadeOut(function () {
						msg.removeClass('contact-error').empty();
					});
					$('#contact-container .contact-title').html('Sending...');
					$('#contact-container form').fadeOut(200);
					$('#contact-container .contact-content').animate({
						height: '110px'
					}, function () {
						$('#contact-container .contact-loading').fadeIn(200, function () {
							$.ajax({
								url: '/data/contact.php',
								data: $('#contact-container form').serialize() + '&action=send',
								type: 'post',
								cache: false,
								dataType: 'html',
								success: function (data) {
									$('#contact-container .contact-loading').fadeOut(200, function () {
										$('#contact-container .contact-title').html('Thank you!');
										msg.html(data).fadeIn(200);
									});
								},
								error: contact.error
							});
						});
					});
				}
				else {
					if ($('#contact-container .contact-message:visible').length > 0) {
						var msg = $('#contact-container .contact-message div');
						msg.fadeOut(200, function () {
							msg.empty();
							contact.showError();
							msg.fadeIn(200);
						});
					}
					else {
						$('#contact-container .contact-message').animate({
							height: '30px'
						}, contact.showError);
					}
					
				}
			});
		},
		close: function (dialog) {
			$('#contact-container .contact-message').fadeOut();
			$('#contact-container .contact-title').html('Goodbye...');
			$('#contact-container form').fadeOut(200);
			$('#contact-container .contact-content').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		validate: function () {
			contact.message = '';
			if (!$('#contact-container #contact-name').val()) {
				contact.message += 'Name is required. ';
			}

			if (contact.message.length > 0) {
				return false;
			}
			else {
				return true;
			}
		},
		validateEmail: function (email) {
			var at = email.lastIndexOf(\"@\");

			// Make sure the at (@) sybmol exists and  
			// it is not the first or last character
			if (at < 1 || (at + 1) === email.length)
				return false;

			// Make sure there aren't multiple periods together
			if (/(\.{2,})/.test(email))
				return false;

			// Break up the local and domain portions
			var local = email.substring(0, at);
			var domain = email.substring(at + 1);

			// Check lengths
			if (local.length < 1 || local.length > 64 || domain.length < 4 || domain.length > 255)
				return false;

			// Make sure local and domain don't start with or end with a period
			if (/(^\.|\.$)/.test(local) || /(^\.|\.$)/.test(domain))
				return false;

			// Check for quoted-string addresses
			// Since almost anything is allowed in a quoted-string address,
			// we're just going to let them go through
			if (!/^\"(.+)\"$/.test(local)) {
				// It's a dot-string address...check for valid characters
				if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
					return false;
			}

			// Make sure domain contains only valid characters and at least one period
			if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(\".\") === -1)
				return false;	

			return true;
		},
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class=\"contact-error\"></div>').append(contact.message))
				.fadeIn(200);
		}
	};

	contact.init();

});
</script>";

set_script($script);
if ($TEMPLATE['model_variants']) {
    $TEMPLATE_models = str_replace(";", ", ", $TEMPLATE['model_variants']);
}
//htmldump($TEMPLATE,'template');
?>

<div class="content_body" id="position">
    <h3><?php echo $TEMPLATE['description']?> <?php echo $TEMPLATE['brand']?> <?php echo $TEMPLATE['model']?></h3>
<p class=articule>Артикул: <?php echo $TEMPLATE['articule']?></p>

<div class=item_image>

                <?php

                $fl = "";
                if (file_exists("uploaded/{$TEMPLATE['bid']}.jpeg")) { $fl = "{$GLOBALS['PATH']}/uploaded/{$TEMPLATE['bid']}.jpeg";
                }
                if (file_exists("uploaded/{$TEMPLATE['bid']}.png")) { $fl = "{$GLOBALS['PATH']}/uploaded/{$TEMPLATE['bid']}.png";
                }
                if (file_exists("uploaded/{$TEMPLATE['bid']}.gif")) { $fl = "{$GLOBALS['PATH']}/uploaded/{$TEMPLATE['bid']}.gif";
                }
        
                if (file_exists("uploaded/big_{$TEMPLATE['bid']}.jpeg")) {
                    $ext=".jpeg";
                }
                if (file_exists("uploaded/big_{$TEMPLATE['bid']}.png")) {
                    $ext=".png";
                }
                if (file_exists("uploaded/big_{$TEMPLATE['bid']}.gif")) {
                    $ext=".gif";
                }            
                if ($fl) {
                    $imgs="";
                    if(glob("uploaded/big_".$TEMPLATE['bid']."_*".$ext)) {
                        foreach(glob("uploaded/big_".$TEMPLATE['bid']."_*".$ext) as $img){
                            //if($img!="uploaded/big_".$TEMPLATE['bid'].$ext){
                             $imgs.="<li style=\"display:none\"><a href=\"".$GLOBALS['PATH']."/".$img."\" rel=\"prettyPhoto[gallery]\" title=\"".$pictitle."\">
				<img {$alt} src='$fl' style=\"cursor:pointer\"></a></li>";
                            //}
                        }
                    }
                    echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";display: table-cell;text-align:center;vertical-align: middle;'>
				<ul class=\"gallery clearfix\" style=\"list-style-type:none\">
				<li><a href=\"/uploaded/big_".$TEMPLATE['bid'].$ext."\" rel=\"prettyPhoto[gallery]\" title=\"".$pictitle."\">
				<img {$alt} src='$fl' style=\"cursor:pointer;border:0\"></a></li>$imgs
				</ul>
				</div>";
                } else {
                    echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";display: table-cell;text-align:center;vertical-align: middle;'><img src='/images/no_image.png' alt='' style=\"height:".$GLOBALS['IMAGE_HMAXSIZE']."px\"></div>";
                }
                ?>



</div>


<div class=card_order>
<div class=itempricecard><?php echo $TEMPLATE['price'] ?> руб.</div>
<div class=itembuycard>
<a class="buy" title="купить <?php echo $buydesc.' '.$picbr ?>" onclick="addToCart(<?php echo $TEMPLATE['aid'] ?>, <?php echo $TEMPLATE['price'] ?>,1);">Купить</a>
</div>
<!--<?php echo $TEMPLATE['characteristics'] ?>-->
<div class=delivery> <a href="/static/delivery">Доставка </a></div>


</div>
<div class=clear></div>
<div class=info>
<?php if ($TEMPLATE['adescription']) { ?>
        <div itemprop="description" class="item_desc" style="padding: 5px; padding-top: 0px;text-align:justify">
        <div class='item_desc'>Описание</div>
    <?php echo $TEMPLATE['adescription'] ?>
        </div>
<?php } ?>

<?php if ($TEMPLATE['characteristics']) { ?>
<div class='characteristics'>
<div class='item_char'>Характеристики</div>
    <?php echo  $TEMPLATE['characteristics'] ?>
</div>
<?php } ?>

<?php if ($TEMPLATE['specification']) { ?>
<div class='characteristics'>
<div class='item_char'>Спецификация</div>
    <?php echo  $TEMPLATE['specification'] ?>
</div>
<?php } ?>

</div>
</div>


