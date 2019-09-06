var toggleMenuAbrir = $('.toggle-menu-abir');
var toggleMenuFechar= $('.toggle-menu-fechar');
var menu = $('.menu');
toggleMenuAbrir.on('click',function () {
    toggleMenuAbrir.addClass('d-none');
    toggleMenuFechar.removeClass('d-none');
    menu.show(250);

});

toggleMenuFechar.on('click',function () {
    toggleMenuAbrir.removeClass('d-none');
    toggleMenuFechar.addClass('d-none');
    menu.slideUp(250);
});

