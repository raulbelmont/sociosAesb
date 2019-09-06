/*Configuração das messages*/
setTimeout(function(){
    $('.mensagem-de-sucesso').hide('slow');
    $('.mensagem-de-sucesso').removeClass('d-block');
}, 4000);
setTimeout(function(){
    $('.mensagem-de-erro').hide('slow');
    $('.mensagem-de-erro').removeClass('d-block');
}, 4000);

/*controlando bloco de cadeiras*/
$(".bloco").on('click',function () {

    var idAtual = $(this).attr('id');


    $('.cadeira-bloco.ativo').addClass('fade');
    $('.cadeira-bloco.ativo').removeClass('ativo');

     var html = "#cadeira-bloco"+idAtual;
     $(html).removeClass('fade');
     $(html).addClass('ativo');
});

/*efeito scroll para links*/
var scrollLink = $('.scroll');
scrollLink.click(function(e) {
    e.preventDefault();
    $('body,html').animate({
        scrollTop: $(this.hash).offset().top
    }, 1000 );
});