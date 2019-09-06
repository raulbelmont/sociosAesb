/*Configurando exibição das mensagens*/
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
    $('#cpfRead').mask('999.999.999-99');
});

/*validando formulario editar*/
$(function () {

    $('#form-editar').validate({

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

var acaoSenha = false;
$('#manter-senha').on('change',function () {
    $('.btn-submit-editar').removeClass('disabled');
    $('.btn-submit-editar').addClass('d-none');
    $('.btn-submit-editar-real').removeClass('d-none');
    $('.senha').addClass('d-none');
    $('.nova-senha').addClass('d-none');
    $('.confirmar-senha').addClass('d-none');
    acaoSenha = false;
});

$('#mudar-senha').on('change',function () {
    $('.btn-submit-editar').removeClass('d-none');
    $('.btn-submit-editar-real').addClass('d-none');
    $('.btn-submit-editar').addClass('disabled');
    $('.senha').removeClass('d-none');
    $('.nova-senha').removeClass('d-none');
    $('.confirmar-senha').removeClass('d-none');
    acaoSenha = true;
});

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

/*Verificando senha antiga*/
$('.btn-submit-editar').on('click',function () {

    if (acaoSenha == false){
        $('#form-editar').submit();
    }else {

        var senha = $('#senha_atual').val();
        var id = $("#id").val();

        $.ajax({
            url: '../controller/meuPerfilADMController.php',
            type: 'POST',
            data:{isSenhaAtual:senha , id:id, acao:1},
            beforeSend: function () {
                $('#spin-senha').removeClass('d-none');
            },
            success: function (data) {
                if (data == true){
                    $('#form-editar').submit();
                }else {

                    $('#spin-senha').addClass('d-none');
                    $('.msg-incorreta').removeClass('d-none');

                }
            },
            error: function (data) {

            }
        });

    }




});

/*Verificando senha para exclusão de perfil*/
$('.btn-submit-excluir').on('click',function () {

        var senha = $('#confirmaSenhaExclusao').val();
        var id = $("#idExclusao").val();

        $.ajax({
            url: '../controller/meuPerfilADMController.php',
            type: 'POST',
            data:{isSenhaAtual:senha , id:id, acao:31},
            beforeSend: function () {
                $('#spin-senha-exclusao').removeClass('d-none');
            },
            success: function (data) {
                if (data == true){
                    $('#form-excluir').submit();
                }else {

                    $('#spin-senha-exclusao').addClass('d-none');
                    $('.msg-senha-excluir').removeClass('d-none');

                }
            },
            error: function (data) {

            }
    });

});