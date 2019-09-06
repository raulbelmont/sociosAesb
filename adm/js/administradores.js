setTimeout(function(){
    $('.mensagem-de-sucesso').hide('slow');
    $('.mensagem-de-sucesso').removeClass('d-block');
}, 4000);
setTimeout(function(){
    $('.mensagem-de-erro').hide('slow');
    $('.mensagem-de-erro').removeClass('d-block');
}, 4000);

/*masks*/
$(document).ready(function(){

    $('#cpf').mask('999.999.999-99');
    $('.cpfread').mask('999.999.999-99');
});

/*validando formulario editar*/
$(function () {

    $('#form-cadastro').validate({

        rules:{

            nome_completo:{
                required:true
            },

            email:{
                required: true,
                minlength: 7
            },

            cpf:{
                required: true,
                minlength: 14
            },

            nova_senha:{
                minlength:6
            },

            confirmar_senha:{
                minlength:6
            },

            senha:{
                required:true
            }
        },

        messages:{
            nome_completo:{
                required: "Informe o seu nome!"
            },
            cpf: {
                required:"Por favor informe o seu CPF!",
                minlength:"Por favor informe um CPF válido!"
            },

            email: {
                required:"Por favor informe o seu E-mail!",
                minlength:"Por favor informe um E-mail válido!"
            },


            nova_senha: {
                required: "Digite uma senha!",
                minlength: "A senha precisa ter no mínimo 6 digitos!"
            },

            confirmar_senha:{
                required: "Digite sua senha novamente!",
                minlength: "A senha precisa ter no mínimo 6 digitos"
            }


        }

    });



});
/*Configurando exibição das mensagens*/


/*Confirmação de senha*/
$('#confirmar_senha').on('keyup',function () {
    var $val1 = $(this).val();
    var $val2 = $('#nova_senha').val();

    if ($val1 == $val2){
        $('.msg-senhas-iguais').removeClass('d-none');
        $('.msg-senhas-diferentes').addClass('d-none');
        $('.btn-submit-editar').removeClass('disabled')



    }else {
        $('.msg-senhas-iguais').addClass('d-none');
        $('.msg-senhas-diferentes').removeClass('d-none');

    }

});

/*Medindo força da senha*/
$('#nova_senha').on('keyup', function () {
    senha = $("#nova_senha").val();
    forca = 0;
    mostra = $("#mostra");
    if((senha.length >= 4) && (senha.length <= 7)){
        forca += 10;
    }else if(senha.length>7){
        forca += 25;
    }
    if(senha.match(/[a-z]+/)){
        forca += 10;
    }
    if(senha.match(/[A-Z]+/)){
        forca += 20;
    }
    if(senha.match(/d+/)){
        forca += 20;
    }
    if(senha.match(/W+/)){
        forca += 25;
    }

    if(forca < 30){
        mostra.html('<tr><td bgcolor="red" width="'+forca+'"></td><td>Fraca </td></tr>');
    }else if((forca >= 30) && (forca < 60)){
        mostra.html('<tr><td bgcolor="yellow" width="'+forca+'"></td><td>Justa </td></tr>');
    }else if((forca >= 60) && (forca < 85)){
        mostra.html('<tr><td bgcolor="blue" width="'+forca+'"></td><td>Forte </td></tr>');
    }else{
        mostra.html('<tr><td bgcolor="green" width="'+forca+'"></td><td>Excelente </td></tr>');
    }

});

/*Verificando cpf*/
$('#cpf').on('keyup',function () {

    var cpf = $('#cpf').val();

    if (cpf.length == 14){
        $.ajax({
            url: '../controller/administradoresController.php',
            type: 'POST',
            data:{cpfVerifica:cpf , acao:11},
            beforeSend: function () {
                $('#spin-cpf').removeClass('d-none');
            },
            success: function (data) {
                if (data == true){
                    $('#spin-cpf').addClass('d-none');
                    $('.cpf-sucesso').removeClass('d-none');
                    $('.cpf-erro').addClass('d-none');
                    $('.btn-novo-user').removeClass('disabled');
                }else {
                    $('#spin-cpf').addClass('d-none');
                    $('.msg-senha-excluir').removeClass('d-none');
                    $('.cpf-sucesso').addClass('d-none');
                    $('.cpf-erro').removeClass('d-none');
                    $('.btn-novo-user').addClass('disabled');
                }
            },
            error: function (data) {

            }
        });
    }







});