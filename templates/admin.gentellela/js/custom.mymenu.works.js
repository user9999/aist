/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** ******  left menu  *********************** **/
$(function () {
    $('#sidebar-menu ul.side-menu li').find('ul.child_menu').each(function() { 
        console.log($(this).siblings(".fa-chevron-down")); 
        $(this).siblings(".fa-chevron-down").css( "display", "inline-block");
    });
    
    $('#sidebar-menu li ul').slideUp();
    $('#sidebar-menu li').removeClass('active');

    $('#sidebar-menu li span.fa-chevron-down').on('click touchstart', function() {
            if ($(this).parent().is('.active')) {
                $(this).parent().removeClass('active');
                $('ul', $(this).parent()).slideUp();
            } else {
                $('#sidebar-menu li').removeClass('active');
                $('#sidebar-menu li ul').slideUp();
                
                $(this).parent().addClass('active');
                $('ul', $(this).parent()).slideDown();
            }
    });
    
/* Sidebar Menu active class */
$(function () {
    var url = window.location;
    $('#sidebar-menu a[href="' + url + '"]').parent('li').addClass('current-page');
    $('#sidebar-menu a').filter(function () {
        return this.href == url;
    }).parent('li').addClass('current-page').parent('ul').slideDown().parent().addClass('active');
});
    $('#menu_toggle').click(function () {
        if ($('body').hasClass('nav-md')) {
            $('body').removeClass('nav-md').addClass('nav-sm');
            $('.left_col').removeClass('scroll-view').removeAttr('style');
            $('.sidebar-footer').hide();

            if ($('#sidebar-menu li').hasClass('active')) {
                $('#sidebar-menu li.active').addClass('active-sm').removeClass('active');
            }
        } else {
            $('body').removeClass('nav-sm').addClass('nav-md');
            $('.sidebar-footer').show();

            if ($('#sidebar-menu li').hasClass('active-sm')) {
                $('#sidebar-menu li.active-sm').addClass('active').removeClass('active-sm');
            }
        }
    });
});

