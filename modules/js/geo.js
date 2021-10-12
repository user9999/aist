$(document).ready(
    function () {
        $('.city').on(
            'change', function () {
                $.cookie('city', this.value, { expires: 365, path: '/' });
                location.reload();
            }
        );
        $('#mycity').click(
            function (event) {
                event.preventDefault();
                //$.cookie('pre');
                $.cookie('city', $.cookie('pre'), { expires: 365, path: '/' });
                location.reload();
            }
        );
        $('#mycity1').click(
            function (event) {
                event.preventDefault();
                //$.cookie('pre');
                $.cookie('city', $.cookie('pre'), { expires: 365, path: '/' });
                location.reload();
            }
        );
    }
);