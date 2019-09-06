/*Configuração das messages*/
setTimeout(function(){
    $('.mensagem-de-sucesso').hide('slow');
    $('.mensagem-de-sucesso').removeClass('d-block');
}, 4000);
setTimeout(function(){
    $('.mensagem-de-erro').hide('slow');
    $('.mensagem-de-erro').removeClass('d-block');
}, 4000);

/*efeitos nos cards dos planos*/
$('.btn-informacoes-abrir').on('click',function () {
    $(this).siblings('.footer-card').slideDown('400');
    $(this).addClass('d-none');
    $(this).siblings('.btn-informacoes-fechar').removeClass('d-none');
});

/*efeitos nos cards dos planos*/
$('.btn-informacoes-fechar').on('click',function () {
    $(this).siblings('.footer-card').slideUp('400');
    $(this).addClass('d-none');
    $(this).siblings('.btn-informacoes-abrir').removeClass('d-none');
});


$(window).resize(function(){

    if ($(window).width() >= 992) {

        $('.footer-card').slideDown(1)


    }

});

$(document).ready(function () {
    $('#mensalidade').mask("#.##0,00", {reverse: true});
    $('#valor_adesao').mask("#.##0,00", {reverse: true});
    $('#valor_adesao_editar').mask("#.##0,00", {reverse: true});
});

var qtdVantagem = 1;
/*Adicionando vantagem*/
$("#add-vantagem").on('click',function () {

    if (qtdVantagem == 0){
        $('#remove-vantagem').removeClass('d-none');
    }

    qtdVantagem = qtdVantagem +1;

    var html = "<div class='form-group col-12 vantagem"+qtdVantagem+"'> <label for='vantagem1'>Vantagem " + qtdVantagem+ "</label> <textarea class='form-control' id='vantagem" + qtdVantagem +"' name='vantagem"+qtdVantagem+"' maxlength='150' placeholder='(Máximo de 150 caractéres)'></textarea>  </div>";
    $('#vantagens').append(html);
    $('#qtd-vantagens').val(qtdVantagem);
});

/*removendo vantagem*/
$("#remove-vantagem").on('click',function () {

    if (qtdVantagem == 1){
        $(this).addClass('d-none');
    }

    if (qtdVantagem>0){
        var html = ".vantagem"+qtdVantagem;
        qtdVantagem = qtdVantagem - 1;
        $(html).remove();
        $('#qtd-vantagens').val(qtdVantagem);
    }



});


/*validando formulario*/
$(function () {

    $('#form-cadastro').validate({

        rules:{

            name:{
                required: true

            },

            payment_methods:{
                required: true
            },

            visibilidade: {
                required: true
            },

            isCadeira: {
                required: true
            },

            valor_adesao:{
                required: true
            },

            mensalidade: {
                required: true
            },

            publico: {
                required: true
            }


        },

        messages:{
            name: {
                required:"Por favor informe um nome para o plano!"
            },

            payment_methods: {
                required: "Escolha o método de pagamento!"
            },

            visibilidade: {
                required: "Escolha a visibilidade!"
            },

            isCadeira: {
                required: "Este campo é obrigatório!"
            },

            valor_adesao: {
                required : "Informe o valor de adesão!"
            },

            mensalidade: {
                required: "Informe o valor da mensalidade!"
            },

            publico: {
                required: "Informe o público alvo do plano!"
            }

        }

    });



});