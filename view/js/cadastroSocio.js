/*masks*/
$(document).ready(function(){

    $('#cpf').mask('999.999.999-99');
    $('#cep').mask('99999-999');
    $("#numero").mask('999999999999999999');
    $("#dataNascimento").mask('99/99/9999');
    $("#dddCelular").mask('99');
    $("#dddResidencial").mask('99');
    $('#telefoneCelular').mask('99999-9999')
    $('#telefoneResidencial').mask('9999-99999')
});

/*validando formulario*/
$(function () {

    $('#form-cadastro').validate({

        rules:{

            nome:{
                required:true
            },

            sobrenome:{
                required: true,
            },

            cpf:{
                required: true,
                minlength: 11
            },

            email:{
                required: true,
                minlength: 7
            },

            dddResidencial:{
              required: false,
              minlength: 2
            },

            telefoneResidencial:{
                required: false,
                minlength: 8
            },

            dddCelular:{
                required: true,
                minlength: 2
            },

            telefoneCelular:{
                required: true,
                minlength: 8
            },

            dataNascimento:{
                required:true,
                minlength:8
            },

            senha:{
                required:true,
                minlength:6
            },

            confirmarSenha:{
                required: true,
                minlength: 6
            },

            pais:{
                required: true
            },

            cidade:{
                required: true
            },

            estado: {
                required: true
            },
            cep: {
                required: true,
            },

            rua: {
                required: true
            },

            numero: {
                required: true
            },

            fotoPerfil: {
                required: true
            }


        },

        messages:{

            nome:{
                required:"Por favor informe o seu nome!"
            },
            sobrenome: {
                required:"Por favor informe o seu sobrenome!",
            },
            cpf: {
                required:"Por favor informe o seu CPF!",
                minlength:"Por favor informe um CPF válido!"
            },

            email: {
                required:"Por favor informe o seu E-mail!",
                minlength:"Por favor informe um E-mail válido!"
            },

            dddResidencial: {
                minlength:"DDD inválido!"
            },

            telefoneResidencial:{
              minlength: "Informe um telefone válido!"
            },

            dddCelular: {
                required: "Informe um DDD!",
                minlength:"DDD inválido!"
            },

            telefoneCelular: {
                required: "Por-favor informe o seu celular!",
                minlength: "Informe um celular válido!"
            },

            dataNascimento: {
                required: "Por-favor informe a data de nascimento!",
                minlength: "Informe uma data válida!"
            },

            senha: {
                required: "Digite uma senha!",
                minlength: "A senha precisa ter no mínimo 6 digitos!"
            },

            confirmarSenha:{
              required: "Digite sua senha novamente!",
              minlength: "A senha precisa ter no mínimo 6 digitos"
            },

            pais: {
                required: "Selecione um país!"
            },

            cidade: {
                required: "Selecione uma cidade!"
            },

            estado: {
                required: "Selecione um estado!"
            },

            cep: {
                required: "Campo é obrigatório!"
            },

            rua: {
                required: "Campo é obrigatório!"
            },

            numero: {
                required: "Campo é obrigatório!"
            },

            fotoPerfil: {
                required: "Selecione uma foto!"
            }




        }

    });



});

/*Confirmação de senha*/
$('#confirmarSenha').on('keyup',function () {

    var $val1 = $(this).val();
    var $val2 = $('#senha').val();

    if ($val1 == $val2){
        $('#msg-senhas-iguais').removeClass('d-none');
        $('#msg-senhas-diferentes').addClass('d-none');



    }else {
        $('#msg-senhas-iguais').addClass('d-none');
        $('#msg-senhas-diferentes').removeClass('d-none');

    }

});

/*Medindo força da senha*/
$('#senha').on('keyup', function () {
    senha = $("#senha").val();
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

/*Validadando pais*/
$('#pais').on('change',function () {

    var valor = $(this).val();
    if (valor != 'Brasil'){
        $('#estado , #cidade').addClass('d-none');
        $('.estado-input , .cidade-input').removeClass('d-none');
        $('.cep').html('Zip Code');
    }else {
        $('#estado , #cidade').removeClass('d-none');
        $('.estado-input , .cidade-input').addClass('d-none');
        $('.cep').html('cep');
    }

});

/*carregando cidades*/
$('#estado').on('change',function () {

    var estado = $(this).val();
    $.ajax({
        url: 'controller/CidadeEstadoController.php',
        type: 'POST',
        data:{estado:estado},
        beforeSend: function () {
            $('#spin-cidades').removeClass('d-none');
        },
        success: function (data) {
            $('#spin-cidades').addClass('d-none');
            $('#cidade').html(data);
        },
        error: function (jqXHR, status, error) {
            $('#spin-cidades').addClass('d-none');
            console.log(error);
            alert('Erro ao buscar cidades!');
        }
    });

});


/*Função para foto de perfil*/
$('.foto-perfil').on('click',function () {
    $('#fotoPerfil').click();
});

/*Pré-visualização da foto*/
$("#fotoPerfil").on('change', function () {

    if (typeof (FileReader) != "undefined") {

        var image_holder = $(".foto-perfil");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "image-holder"
            }).appendTo(image_holder);
        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
    } else{
        alert("Este navegador nao suporta FileReader.");
    }
});



/*scroll top*/
$(document).on('scroll',function () {
    if ($(window).scrollTop() > 200){
        $('#scroll-top').slideDown(200);
    }else {
        $('#scroll-top').slideUp(200);
    }


});

$('#scroll-top').click(function (e) {
    e.preventDefault();
    $('body,html').animate({
        scrollTop : 0
    }, 1000)
})