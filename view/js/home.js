    $(document).ready(function() {
        $('#modal-planos').modal('show');
    });

    $('.btn-modal').on('click',function () {
        $('#modal-planos').modal('hide');
    });

    /*abrir menu principal*/
    $(".toggle-menu-abir").click(function () {
        $(".menu").slideDown(350);
        $(this).addClass('d-none');
        $('.toggle-menu-fechar').removeClass('d-none');
    });

    /*Fechar menu principal*/
    $(".toggle-menu-fechar").on('click',function () {
        $(".menu").slideUp(350);
        $(this).addClass('d-none');
        $('.toggle-menu-abir').removeClass('d-none');
    });

    /*Fechar menu*/
    $(".conteudo").on('click',function () {
        $(".menu").slideUp(350);
        $(".toggle-menu-fechar").addClass('d-none');
        $('.toggle-menu-abir').removeClass('d-none');
    });

    $('.nav-item').on('click',function () {
        $(".menu").slideUp(350);
        $(".toggle-menu-fechar").addClass('d-none');
        $('.toggle-menu-abir').removeClass('d-none');
    });

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

    /*Efeitos de scroll*/
    // Smooth scrolling
    var scrollLink = $('.scroll');
    scrollLink.click(function(e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: $(this.hash).offset().top
        }, 1000 );
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

    /*masks*/
    $(document).ready(function(){

        $('#cpf').mask('999.999.999-99');
        $('#cpfRec').mask('999.999.999-99');

    });

    $(function () {
        $('#form-recuperar-senha').validate({

            rules: {
                cpf:{
                    required: true,
                    minlength: 14
                },

                email:{
                    required: true,
                    minlength: 7
                }

            },

            messages: {
                cpf: {
                    required:"Por favor informe o seu CPF!",
                    minlength:"Por favor informe um CPF válido!"
                },
                email: {
                    required:"Por favor informe o seu E-mail!",
                    minlength:"Por favor informe um E-mail válido!"
                },
            }

        })
    });

    /*validando formulario*/
    $(function () {

        $('#form-login').validate({

            rules:{

                cpf:{
                    required: true,
                    minlength: 14
                },

                senha:{
                    required:true,
                    minlength:6
                }

            },

            messages:{
                cpf: {
                    required:"Por favor informe o seu CPF!",
                    minlength:"Por favor informe um CPF válido!"
                },

                senha: {
                    required: "Digite uma senha!",
                    minlength: "A senha precisa ter no mínimo 6 digitos!"
                }
            }

        });



    });


    /*Login*/
    $('#form-login').on('submit',function (event) {
        event.preventDefault();
        var cpf = $('#cpf').val();
        var senha = $('#senha').val();
        if ((cpf.length == 14) && (senha.length >= 6)){
            $.ajax({
                url: 'controller/loginController.php',
                type: 'POST',
                data:{cpf:cpf, senha:senha },
                beforeSend: function () {
                    $('#form-login').slideUp(10);
                    $('.spin-login').slideDown(10);
                },
                success: function (data) {
                    if (data != false){
                        location.href=data;
                    }else {
                        $('#form-login').slideDown(650);
                        $('.spin-login').slideUp(650);
                        $('#alerta-erro').slideDown(1500);
                    }
                },
                error: function (jqXHR, status, error) {
                    $('#form-login').slideDown(650);
                    $('.spin-login').slideUp(650);
                    $('#alerta-erro').slideDown(650);
                }
            });

        }else {

        }

    });

    /*Recuperar senha*/
    $('#form-recuperar-senha').on('submit',function (event) {
        event.preventDefault();
        var cpf = $('#cpfRec').val();
        var email = $('#emailRec').val();
        if ((cpf.length == 14) && (email.length >= 7)){
            $.ajax({
                url: 'controller/recuperarSenhaController.php',
                type: 'POST',
                data:{cpf:cpf, email:email},
                beforeSend: function () {
                    $('#form-recuperar-senha').slideUp(10);
                    $('.spin-recuperar-senha').slideDown(10);
                },
                success: function (data) {
                    console.log(data)
                    if (data == true){
                        $('.spin-recuperar-senha').slideUp(650);
                        $('.sucesso-recuperar-senha').slideDown(650);
                    }else {
                        $('#form-recuperar-senha').slideDown(650);
                        $('.spin-recuperar-senha').slideUp(650);
                        $('#alerta-erro-senha').slideDown(1500);
                    }
                },
                error: function (jqXHR, status, error) {
                    $('#form-recuperar-senha').slideDown(650);
                    $('.spin-recuperar-senha').slideUp(650);
                    $('#alerta-erro-senha').slideDown(650);
                }
            });

        }else {

        }

    });











