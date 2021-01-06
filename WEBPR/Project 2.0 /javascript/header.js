window.addEventListener("resize", resize);
resize();

function resize() {
    var changeNav = "";
    var changeTitle = "";
    var currentNav = "";
    var currentTitle = "";
    if (window.innerWidth < 1050) {
        changeNav = 'navHidden';
        changeTitle = 'titleHidden';
        currentNav = 'nav';
        currentTitle = 'LogoTitle';
    } else {
        changeNav = 'nav';
        changeTitle = 'LogoTitle';
        currentNav = 'navHidden';
        currentTitle = 'titleHidden';
    }
    var arrayNavs = document.getElementsByClassName(currentNav);
    var title = document.getElementsByClassName(currentTitle);
    while (arrayNavs.length > 0) {
        if (arrayNavs[0] != null)
            arrayNavs[0].className = changeNav;
    }
    if (title[0] != null)
        title[0].className = changeTitle;

}