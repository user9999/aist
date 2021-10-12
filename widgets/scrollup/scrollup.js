window.onload = function () {
    // после загрузки страницы
    function up()
    {
        var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
        if(top > 0) {
            window.scrollBy(0,-100);
            t = setTimeout('up()',20);
        } else { clearTimeout(t);
        }
        return false;
    }
    var scrollUp = document.getElementById('scrollup'); // найти элемент

    scrollUp.onmouseover = function () {
        // добавить прозрачность
        scrollUp.style.opacity=0.3;
        scrollUp.style.filter  = 'alpha(opacity=30)';
    };

    scrollUp.onmouseout = function () {
        //убрать прозрачность
        scrollUp.style.opacity = 0.5;
        scrollUp.style.filter  = 'alpha(opacity=50)';
    };

    scrollUp.onclick = function () {
        //обработка клика
        window.scrollTo(0,0);
    };

    // show button

    window.onscroll = function () {
        // при скролле показывать и прятать блок
        if (window.pageYOffset > 0 ) {
            scrollUp.style.display = 'block';
        } else {
            scrollUp.style.display = 'none';
        }
    };
};