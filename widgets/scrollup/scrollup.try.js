window.onload = function () {
    // после загрузки страницы
    var scrollUp = document.getElementById('scrollup'); // найти элемент
    var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
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
        //top = 1000;
        //var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
        while(top > 0) {
            t = setInterval(window.scrollBy(0,-50),200);
            top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
        }
        clearInterval(t);
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