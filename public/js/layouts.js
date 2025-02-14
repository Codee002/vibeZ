//sidebar
var sidebar = document.getElementById("menusidebar");

sidebar.onmousemove = () => {
    sidebar.classList.add("active_menu");
}

sidebar.onmouseout= () => {
    sidebar.classList.remove("active_menu");
}
// Ham hien totop
var totop = document.getElementById("totop");

window.onscroll = () => {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300)
        totop.classList.add("activeTotop")
    else
        totop.classList.remove("activeTotop")
}
