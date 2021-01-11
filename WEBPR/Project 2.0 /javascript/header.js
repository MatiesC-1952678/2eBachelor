window.addEventListener("resize", resize);
resize();

function resize() {
    var changeNav = "";
    var changeTitle = "";
    var changeLogo = "";
    var currentNav = "";
    var currentTitle = "";
    var currentLogo = "";
    if (window.innerWidth < 1150) {
        changeNav = 'navHidden';
        changeTitle = 'titleHidden';
        changeLogo = 'LogoSmaller';
        currentNav = 'nav';
        currentTitle = 'LogoTitle';
        currentLogo = 'Logo';
    } else {
        changeNav = 'nav';
        changeTitle = 'LogoTitle';
        changeLogo = 'Logo';
        currentNav = 'navHidden';
        currentTitle = 'titleHidden';
        currentLogo = 'LogoSmaller';
    }
    var arrayNavs = document.getElementsByClassName(currentNav);
    while (arrayNavs.length > 0) {
        if (arrayNavs[0] !== null)
            arrayNavs[0].className = changeNav;
    }
    var logo = document.getElementsByClassName(currentLogo);
    var title = document.getElementsByClassName(currentTitle);
    if (title[0] !== null)
        title[0].className = changeTitle;
    if (logo[0] !== null)
        logo[0].className = changeLogo;

}