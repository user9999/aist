$(function () {
$('table.recursive tr').each(function() {
    $(this).find('td').each (function() {
        $(this).addClass('editable');
        //console.log($(this));
    });

});
});

