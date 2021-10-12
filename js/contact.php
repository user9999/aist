/*
 * SimpleModal Contact Form
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */
<?php
require "../inc/configuration.php";
require_once "../inc/functions.php";
require_once "../inc/lang.php";
$userlanguage=userlang();
?>
jQuery(function ($) {

    var contact = {
    
        message: null,
        init: function () {

            $('#contact-form input.contact, #contact-form a.contact').click(function (e) {
                e.preventDefault();

                // load the contact form using ajax
                $.get("/ajax/register.php", function(data){
                    // create a modal dialog with the data
                    $(data).modal({
                        closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
                        position: ["15%",],
                        overlayId: 'contact-overlay',
                        containerId: 'contact-container',
                        onOpen: contact.register,
                        onShow: contact.show,
                        onClose: contact.close
                    });
                });
            });
            $('#contact-form a.login').click(function (e) {
                e.preventDefault();

                // load the contact form using ajax
                $.get("/ajax/login.php", function(data){
                    // create a modal dialog with the data
                    $(data).modal({
                        closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
                        position: ["15%",],
                        overlayId: 'contact-overlay',
                        containerId: 'contact-container',
                        onOpen: contact.login,
                        onShow: contact.showlogin,
                        onClose: contact.close
                    });
                });
            });
            
        },
        register: function (dialog) {
            // dynamically determine height


            var h = 520;

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
                            $('#contact-container .info').fadeIn(200);
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
        login: function (dialog) {
            // dynamically determine height


            var h = 300;

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
                        height: '80px'
                    }, function () {
                        $('#contact-container .contact-loading').fadeIn(200, function () {
                            $.ajax({
                                url: '/ajax/register.php',
                                data: $('#contact-container form').serialize() + '&action=send&title=registration',
                                type: 'post',
                                cache: false,
                                dataType: 'html',
                                success: function (data) {
                                    $('#contact-container .contact-loading').fadeOut(200, function () {
                                        $('#contact-container .contact-title').html('<?php echo $GLOBALS['dblang_attention'][$userlanguage] ?>!');
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
        showlogin: function (dialog) {
            $('#contact-container .contact-send').click(function (e) {
                e.preventDefault();
                // validate form
                if (contact.validatelogin()) {
                    var msg = $('#contact-container .contact-message');
                    msg.fadeOut(function () {
                        msg.removeClass('contact-error').empty();
                    });
                    $('#contact-container .contact-title').html('Sending...');
                    $('#contact-container form').fadeOut(200);
                    $('#contact-container .contact-content').animate({
                        height: '80px'
                    }, function () {
                        $('#contact-container .contact-loading').fadeIn(200, function () {
                            $.ajax({
                                url: '/ajax/login.php',
                                data: $('#contact-container form').serialize() + '&action=send',
                                type: 'post',
                                cache: false,
                                dataType: 'html',
                                success: function (data) {
                  if(data=='OK'){
                    window.location.href = "/profile";
                  }
                                    $('#contact-container .contact-loading').fadeOut(200, function () {
                    
                                        $('#contact-container .contact-title').html('Внимание!');
                                        console.log($('#contact-container').parent());
                                        
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
            $('#contact-container .contact-title').html('');
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

            //if (!$('#contact-container #contact-birthdate').val()) {
                //contact.message += 'Введите Дату рождения. ';
            //}
            if (!$('#contact-container #contact-secpic').val()) {
                contact.message += '<?php echo $GLOBALS['dblang_check'][$userlanguage] ?>. ';
            }
            if (!$('#contact-container #contact-nick').val()) {
                contact.message += '<?php echo $GLOBALS['dblang_checknick'][$userlanguage] ?>. ';
            }
            //if (!$('#contact-container #contact-name').val()) {
                //contact.message += 'Введите имя. ';
            //}
            //if (!$('#contact-container #contact-phone').val()) {
                //contact.message += 'Введите № телефона. ';
            //}
            var email = $('#contact-container #contact-email').val();
            if (!email) {
                contact.message += 'Введите Email. ';
            }
            else {
                if (!contact.validateEmail(email)) {
                    contact.message += 'Неверный Email. ';
                }
            }

            //if (!$('#contact-container #contact-message').val()) {
                //contact.message += 'Введите адрес доставки.';
            //}

            if (contact.message.length > 0) {
                return false;
            }
            else {
                return true;
            }
        },
        validatelogin: function () {
            contact.message = '';

            var email = $('#contact-container #contact-email').val();
            if (!email) {
                contact.message += 'Введите Email. ';
            }
            else {
                if (!contact.validateEmail(email)) {
                    contact.message += 'Неверный Email. ';
                }
            }

            if (contact.message.length > 0) {
                return false;
            }
            else {
                return true;
            }
        },
        validateEmail: function (email) {
            var at = email.lastIndexOf("@");

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
            if (!/^"(.+)"$/.test(local)) {
                // It's a dot-string address...check for valid characters
                if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
                    return false;
            }

            // Make sure domain contains only valid characters and at least one period
            if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(".") === -1)
                return false;    

            return true;
        },
        showError: function () {
            $('#contact-container .contact-message')
                .html($('<div class="contact-error"></div>').append(contact.message))
                .fadeIn(200);
        }
    };

    contact.init();

});