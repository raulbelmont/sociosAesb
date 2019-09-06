<?php
require_once 'model/Usuario.php';
require_once 'model/Administrador.php';
require_once 'model/Plano.php';
require_once 'model/PlanoVantagem.php';

$usuarioClass = new Usuario();
$administradorClass = new Administrador();
$planoClass = new Plano();
$planoVantagemClass = new PlanoVantagem();

/*Verificando login e defiindo usuario*/
if (!session_id()) session_start();
if (!empty($_SESSION['isLogado']) and $_SESSION['isLogado'] == true){
    if ($_SESSION['user_type'] == 'usuario'){
        $usuario = $usuarioClass->select($_SESSION['user_id']);
        header('Location:socio/index.php');
    }else{
        if ($_SESSION['user_type'] == 'administrador'){
            $usuario = $administradorClass->select($_SESSION['user_id']);
            header('Location:adm/index.php');
        }else{

        }
    }
}else{

}

?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="view/css/home.css">

        <link rel="icon" href="view/image/logo.png" type="image/x-icon" />
        <link rel="shortcut icon" href="view/image/logo.png" type="image/x-icon" />

        <title>AESB - Sócios</title>
    </head>

    <body>


        <header>
            <div class="container-fluid">
                <div class="row justify-content-end">

                    <!--Menu aberto-->
                    <div class="menu">
                        <a class="nav-link nav-item scroll py-3" href="#row-planos">Associe-se</a>
                        <a class="nav-link nav-item scroll py-3" href="#row-vantagens">Vantagens</a>
                        <a class="nav-link nav-item py-3" href="#">Contratos de associação</a>
                        <a class="nav-link nav-item py-3" href="https://aesaoborja.com.br/view/contato.php" target="_blank">Fale conosco</a>
                        <a class="nav-link nav-item py-3" href="#">Políticas e termos de uso</a>
                        <a class="nav-link nav-item py-3" href="https://aesaoborja.com.br/view/index.php" target="_blank">Site do clube</a>
                    </div>

                    <!--Menu do topo-->
                    <div class="nav menu-topo d-flex w-100 position-fixed pl-3">

                        <!--toggle-->
                        <i class="fas fa-bars fa-2x my-auto mx-2 text-white toggle-menu-abir"></i>
                        <i class="d-none fas fa-times fa-2x my-auto mx-2 text-white toggle-menu-fechar"></i>

                        <!--logo-->
                        <figure class="">
                            <a href="home.php"><img class="logo-menu my-auto ml-2 ml-md-4" src="view/image/logo.png"></a>
                            <figcaption></figcaption>
                        </figure>
                        <div class="my-auto d-none d-sm-block ml-1">
                            <a href="home.php">
                            <h5 class="font-weight-bold text-white text-uppercase my-0">Portal de</h5>
                            <h5 class="font-weight-bold text-white text-uppercase my-0">Sócios</h5>
                            </a>
                        </div>

                        <h5 class="ml-auto my-auto mr-3 p-1 px-3">
                            <a data-toggle="modal" data-target="#modal-login" class="btn-login font-weight-bold text-white"><span>Login <i class="fas fa-sign-in-alt"></i></span></a>
                        </h5>

                    </div>
                </div>
            </div>


        </header>

        <main class="conteudo">
            <div class="container-fluid">

                <!--Imagem de apresentacao-->
                <div class="row justify-content-center">
                    <div class="col-12 m-0 p-0 apresentacao">
                        <picture class="w-100">
                            <source media="(min-width: 768px)" srcset="view/image/fundo-inicio.jpg" class="w-100">
                            <source media="(max-width: 767px)" srcset="view/image/fundo-inicio-mobile.jpg" class="w-100">
                            <img src="view/image/fundo-inicio-mobile.jpg" class="w-100">
                        </picture>
                    </div>
                </div>


                <!--planos-->
                <div id="row-planos" class="row justify-content-center row-planos pt-5">

                    <h1 class="titulo-planos text-uppercase text-center col-12 mt-5 font-weight-bold mb-4 text-white">Confira os planos e escolha o melhor pra você</h1>


                    <?php foreach ($planoClass->selectAllPublic(1) as $key => $value): ?>
                    <!--plano-->
                    <div class="card p-0 m-3 plano-card col-11 col-sm-6 col-lg-3">

                        <div class="card-header">
                            <h4 class="text-uppercase text-center"><?=$value->name_plan?></h4>
                        </div>

                        <div class="card-body p-0 pb-3 text-center">
                            <p class="my-0 pl-3 text-left">Valor da mensalidade:</p>
                            <h1 class="text-left pl-3 text-uppercase font-weight-bold my-0">R$ <?=$value->mensalidade?></h1>
                            <p class="mt-0 mb-4 pl-3 text-left">Valor da adesão: R$ <?=$value->valor_adesao?></p>

                            <a href="cadastroSocio.php?plan=<?=$value->id_pagarme?>" class="text-uppercase py-2 px-3 text-center btn-associarse">Associar-se <i class="fas fa-angle-right"></i></a>

                            <p class="text-center mt-4 btn-informacoes d-lg-none btn-informacoes-abrir text-danger">Mais Informações <i class="fas fa-angle-down"></i></p>
                            <p class="text-center mt-4 btn-informacoes btn-informacoes-fechar text-danger d-none d-lg-none">Menos <i class="fas fa-angle-up"></i></p>

                            <div class="text-left mt-4 footer-card">
                                <ul class="pl-3">
                                    <?php foreach ($planoVantagemClass->selectByPlano($value->id) as $key => $valueVantagem): ?>
                                    <li class="my-1"><?=$valueVantagem->vantagem?></li>
                                    <?php endforeach; ?>
                                    <li class="my-1 font-weight-bold"><?=$value->publico?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>

                <!--Vantagens-->
                <div id="row-vantagens" class="row justify-content-center row-vantagens py-5 ">

                    <h1 class="text-center text-uppercase col-12 font-weight-light mb-5">Vantagens em ser sócio da AESB</h1>

                    <!--Vantagem-->
                    <div class="col-11 col-sm-6 col-lg-3 m-2 card-vantagem d-flex align-items-center">
                        <div class="d-block">
                            <p class="text-center text-white"><i class="fas fa-ticket-alt fa-3x"></i></p>
                            <h5 class="text-center text-uppercase font-weight-bold text-white">Descontos na compra de produtos e ingressos</h5>
                        </div>
                    </div>

                    <!--Vantagem-->
                    <div class="col-11 col-sm-6 col-lg-3 m-2 card-vantagem d-flex align-items-center">
                        <div class="d-block">
                            <p class="text-center text-white"><i class="fas fa-desktop fa-3x"></i></p>
                            <h5 class="text-center text-uppercase font-weight-bold text-white">Assistir gratuitamente aos jogos da AESB como mandante</h5>
                        </div>
                    </div>


                    <!--Vantagem-->
                    <div class="col-11 col-sm-6 col-lg-3 m-2 card-vantagem d-flex align-items-center">
                        <div class="d-block">
                            <p class="text-center text-white"><i class="fas fa-chair fa-3x"></i></p>
                            <h5 class="text-center text-uppercase font-weight-bold text-white">Tenha uma cadeira cativa no estádio personalizada com o seu nome</h5>
                        </div>
                    </div>

                    <p class="text-danger text-center text-uppercase col-12 mt-3"><i class="fas fa-asterisk"></i> As vantagens variam de acordo com o plano escolhido</p>


                    <div class="col-10 mt-5 row-vantagens-footer text-center">
                        <h4 class="text-center text-uppercase mt-3 mb-4 text-white">Confira os planos e seus benefícios e escolha o melhor para você</h4>
                        <a href="#row-planos" class="font-weight-bold py-2 px-3 text-white scroll">Ver planos <i class="fas fa-angle-up"></i></a>
                        <p class="invisible my-0">sad</p>
                    </div>


                </div>

                <!--Modal com planos-->
                <div class="row">
                    <div class="modal fade" id="modal-planos" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <button type="button" class="close text-right my-2 mr-3" data-dismiss="modal" aria-label="Close">
                                    <span class="text-uppercase" aria-hidden="true">Fechar <i class="fas fa-times"></i></span>
                                </button>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">

                                            <div class="col-12 col-sm-10 col-md-8 col-xl-5 m-2">
                                                <a href="#row-planos" class="scroll btn-modal">
                                                    <img src="view/image/plano1.jpg" class="img-fluid">
                                                </a>
                                            </div>

                                            <div class="col-12 col-sm-10 col-md-8 col-xl-5 m-2">
                                                <a href="#row-planos" class="scroll btn-modal">
                                                    <img src="view/image/plano2.jpg" class="img-fluid">
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal de login-->
                <div class="row">
                    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title titulo-modal text-uppercase">Login</h1>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <h4 id="alerta-erro" class="text-center text-white bg-danger text-uppercase p-1">CPF ou Senha Incorretos <i class="fas fa-exclamation-circle"></i></h4>

                                    <form id="form-login" enctype="multipart/form-data" action="controller/loginController.php" method="post">

                                        <div class="form-row justify-content-center">

                                            <!--CPF-->
                                            <div class="form-group col-12">
                                                <label for="cpf" class="text-uppercase"><i class="fas fa-user"></i> CPF <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="___.___.___-__" required>
                                            </div>

                                            <!--CPF-->
                                            <div class="form-group col-12">
                                                <label for="senha" class="text-uppercase"><i class="fas fa-key"></i> Senha <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="senha" name="senha" required>
                                            </div>

                                            <a data-toggle="modal" data-target="#modal-recuperar-senha" class="col-12 btn-recuperar-seha" data-dismiss="modal" aria-label="Close">Esqueci a senha</a>

                                            <div class="form-group col-10 mt-3">
                                                <button type="submit" class="btn-entrar btn-block py-2">Entrar <i class="fas fa-sign-in-alt"></i></button>
                                            </div>

                                        </div>

                                    </form>

                                    <!--Carregamento-->
                                    <div class="container-fluid p-5 spin-login">
                                        <div class="row my-5 justify-content-center">
                                            <h2 class="text-uppercase text-center col-12 my-2">Validando os dados</h2>

                                            <div class="col-12 text-center my-2">
                                                <i id="spin-login" class="fas fa-sync-alt fa-3x fa-spin fa-fw"> </i>
                                            </div>

                                            <p class="text-center col-12 my-2">Aguarde. Em instantes você será redirecionado pra sua página inicial.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal de recuperar senha-->
                <div class="row">
                    <div class="modal fade" id="modal-recuperar-senha" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title titulo-modal text-uppercase">Recuperar senha</h1>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <h4 id="alerta-erro-senha" class="text-center text-white bg-danger text-uppercase p-1">CPF ou E-mail incorretos <i class="fas fa-exclamation-circle"></i></h4>

                                    <form id="form-recuperar-senha" enctype="multipart/form-data" action="controller/recuperarSenhaController.php" method="post">

                                        <div class="form-row justify-content-center">

                                            <!--CPF-->
                                            <div class="form-group col-12">
                                                <label for="cpfRec" class="text-uppercase"><i class="fas fa-user"></i> Digite seu CPF <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="cpfRec" name="cpf" placeholder="___.___.___-__" required>
                                            </div>

                                            <!--CPF-->
                                            <div class="form-group col-12">
                                                <label for="emailRec" class="text-uppercase"><i class="fas fa-envelope"></i> Digite o E-mail de cadastro <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="emailRec" name="email" required>
                                            </div>

                                            <div class="form-group col-10 mt-3">
                                                <button type="submit" class="btn-entrar-senha btn-block py-2">Recuperar <i class="fas fa-key"></i></button>
                                            </div>

                                        </div>

                                    </form>

                                    <!--Carregamento-->
                                    <div class="container-fluid p-5 spin-recuperar-senha">
                                        <div class="row my-5 justify-content-center">
                                            <h2 class="text-uppercase text-center col-12 my-2">Validando os dados</h2>

                                            <div class="col-12 text-center my-2">
                                                <i id="" class="fas fa-sync-alt fa-3x fa-spin fa-fw"> </i>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Sucesso-->
                                    <div class="container-fluid p-5 sucesso-recuperar-senha">
                                        <div class="row my-5 justify-content-center">
                                            <h2 class="text-uppercase text-center col-12 my-2 verfica-email">Verifique seu e-mail!</h2>
                                            <h5 class="text-uppercase text-center col-12 my-2">Uma nova senha de acesso foi enviada pro seu E-mail!</h5>
                                            <i class="fas fa-envelope text-center fa-3x"></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <footer class="conteudo">
            <!--Botão voltar ao topo-->
            <a id="scroll-top" class="text-white text-center position-fixed px-2 py-1"><i class="fas fa-angle-up fa-2x"></i></a>

            <div class="container-fluid">

                <!--Social-->
                <div class="row rodape-social d-flex pt-2">

                    <div class="col-12 media-sociais text-center align-self-center">
                        <ul class="list-unstyled list-inline botoes-medias-sociais">

                            <h3 class="font-weight-bold text-uppercase titulo-social">Siga a <span class="text-uppercase">AESB</span></h3>

                            <!--FACEBOOK-->
                            <li class="list-inline-item mt-1">
                                <a class="botao-facebook mx-1 d-flex" href="https://www.facebook.com/aesbsaoborja/">
                                    <i class="fab fa-facebook align-self-center mx-auto"></i>
                                </a>
                            </li>

                            <!--INSTAGRAM-->
                            <li class="list-inline-item mt-1">
                                <a class="botao-instagram mx-1 d-flex" href="https://www.instagram.com/ae_saoborja">
                                    <i class="fab fa-instagram align-self-center mx-auto"></i>
                                </a>
                            </li>

                            <!--TWITTER-->
                            <li class="list-inline-item mt-1">
                                <a class="botao-twitter mx-1 d-flex" href="https://twitter.com/ae_saoborja">
                                    <i class="fab fa-twitter align-self-center mx-auto"> </i>
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>

                <!--Links do menu-->
                <div class="row menu-footer d-flex align-items-center position-relative py-4">
                    <div class="col-12 d-block text-center">
                        <ul class="list-inline m-0 position-relative">
                            <li class="list-inline-item mx-2"><a class="scroll" href="#row-planos">Associe-se</a></li>
                            <li class="list-inline-item mx-2"><a class="scroll do" href="#row-vantagens">Vantagens</a></li>
                            <li class="list-inline-item mx-2"><a href="" class="do">Contratos de associação</a></li>
                            <li class="list-inline-item mx-2"><a class="do" href="https://aesaoborja.com.br/view/contato.php" target="_blank">Fale conosco</a></li>
                            <li class="list-inline-item mx-2"><a class="do" href="">Políticas e termos de uso</a></li>
                            <li class="list-inline-item mx-2"><a class="do" href="https://aesaoborja.com.br/view/index.php" target="_blank">Site do clube</a></li>
                        </ul>
                    </div>
                </div>

                <!--Rodapé-->
                <div class="row rodape-final d-flex justify-content-center">

                    <!--Logo e direitos-->
                    <div class="col-12 col-lg-4 d-block d-lg-flex text-center align-items-center my-2">
                        <img class="imagem-rodape mr-2" src="view/image/logo.png">
                        <div class="d-block">
                            <p class="text-white my-0 text-uppercase">Associação Esportiva São Borja</p>
                            <p class="text-white my-0">© 2018 Todos os direitos reservados</p>
                        </div>
                    </div>

                    <!--Infos pra contato-->
                    <div class="col-12 col-lg-4 d-flex align-items-center text-center justify-content-center contato my-2 py-2">
                        <ul class="list-unstyled text-white">
                            <li><i class="far fa-envelope"></i> contato@aesaoborja.com.br</li>
                            <li><i class="far fa-building"></i> CNPJ: 10.724.687/0001-61</li>
                            <li><i class="fas fa-phone"></i> (55) 3431-0162</li>
                        </ul>
                    </div>

                    <div class="col-12 col-lg-4 d-flex align-self-end justify-content-end order-last">
                        <a href="https://www.facebook.com/inpactustec/" target="_blank"><img src="view/image/inpactusrodape.png" class="logo-inpactus mr-5"></a>
                    </div>
                </div>

            </div>

        </footer>





        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="view/js/jquery.mask.js"></script>
        <script src="view/js/jquery.validate.js"></script>
        <script src="view/js/home.js"></script>
    </body>



</html>