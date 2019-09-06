<?php
    require_once 'model/autoloadClass.php';
    $autoload = new autoloadClass();
    $cidade = new Cidade();
    $estado = new Estado();
    $paises = new Pais();

?>

<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="view/css/cadastroSocio.css">

    <link rel="icon" href="view/image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="view/image/logo.png" type="image/x-icon" />

    <title>AESB - Sócios</title>
</head>

<body>

    <header>

        <div class="container-fluid">
            <div class="row justify-content-center cabecalho py-1">

                <div class="col-12 col-lg-2 text-center text-lg-right">
                    <img src="view/image/logo.png" class="logo-menu">
                </div>

                <div class="col-12 col-lg-9 d-flex align-items-center">
                    <h2 class="text-uppercase text-center text-lg-left text-white font-weight-bold">Faça parte da nossa torcida de carteirinha</h2>
                </div>

            </div>
        </div>

    </header>

    <main class="py-5 bg-light">

        <div class="container-fluid">
            <div class="row justify-content-center">

                <!--Planos-->
                <div class="planos col-12">

                </div>

                <div class="formulario-cadastro col-12 col-md-11 col-lg-10">
                    <form id="form-cadastro" enctype="multipart/form-data" method="post" action="controller/cadastro.php">
                        <div class="form-row">

                            <!--Dados Pessoais-->
                            <h4 class="text-uppercase font-weight-bold col-12 mb-5 text-center">Dados pessoais</h4>

                            <!--Nome-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="nome">Nome <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <!--Sobrenome-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="sobrenome">Sobrenome <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
                            </div>

                            <!--CPF-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="cpf">CPF <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="___.___.___-__" required>
                            </div>

                            <!--E-mail-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="email">E-mail <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>

                            <!-- telefone e Ddd residencial-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="dddResidencial">Telefone (residencial)</label>
                                <div class="row">
                                    <input type="text" class="form-control col-3 mx-3" id="dddResidencial" name="dddResidencial" placeholder="DDD">
                                    <input type="text" class="form-control col-7" id="telefoneResidencial" name="telefoneResidencial" placeholder="_____-____">
                                </div>
                            </div>

                            <!-- telefone e Ddd celular-->
                            <div class="form-group col-12 col-sm-6">
                                <label>Celular <span class="text-danger font-weight-bold">*</span></label>
                                <div class="row">
                                    <input type="text" class="form-control col-3 mx-3" id="dddCelular" name="dddCelular" placeholder="DDD" required>
                                    <input type="text" class="form-control col-7" id="telefoneCelular" name="telefoneCelular" placeholder="_____-____" required>
                                </div>
                            </div>

                            <!--Data de nascimento-->
                            <div class="form-group col-12 col-sm-6 col-md-4">
                                <label for="dataNascimento">Data de Nascimento <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="dataNascimento" name="dataNascimento" placeholder="DD/MM/AAAA" required>
                            </div>

                            <p class="invisible col-12"></p>


                            <!--Senha-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="senha" class="font-weight-bold">Senha <span class="text-danger font-weight-bold">*</span></label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                                <table id="mostra"></table>
                            </div>

                            <!--Confirmar senha-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="confirmarSenha" class="font-weight-bold">Confirmar senha <span class="text-danger font-weight-bold">*</span></label>
                                <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required>
                            </div>
                            <p id="msg-senhas-diferentes" class="col-12 text-center text-danger d-none">As senhas precisam ser iguais!</p>
                            <p id="msg-senhas-iguais" class="col-12 text-center text-success d-none">Ok!</p>

                            <!--Endereço-->
                            <h4 class="text-uppercase font-weight-bold col-12 mb-5 my-3 text-center">Endereço</h4>

                            <!--País-->
                            <div class="form-group col-12 col-sm-4 col-md-5">
                                <label for="pais">País <span class="text-danger font-weight-bold">*</span></label>
                                <select id="pais" name="pais" class="form-control">
                                    <option value="" selected></option>
                                    <?php foreach ($paises->selectAll() as $key => $value): ?>
                                        <option value="<?=$value->SL_NOME_PT?>"><?=$value->SL_NOME_PT?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!--UF-->
                            <div class="form-group col-12 col-sm-4 col-md-2">
                                <label for="estado">Estado <span class="text-danger font-weight-bold">*</span></label>
                                <select id="estado" name="estado" class="form-control" required>
                                    <option value="" selected></option>
                                    <?php foreach ($estado->selectAll() as $key => $value): ?>
                                        <option value="<?=$value->sigla?>"><?=$value->nome?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" id="estado" name="estado" class="form-control d-none estado-input" required>
                            </div>

                            <!--Cidade-->
                            <div class="form-group col-12 col-sm-4 col-md-5">
                                <label id="label-cidades" for="cidade">Cidade <span class="text-danger font-weight-bold">*</span> <i id="spin-cidades" class="fas fa-sync-alt fa-spin fa-fw d-none"> </i></label>
                                <select id="cidade" name="cidade" class="form-control">
                                    <option value="" selected></option>
                                    <option value="">...Selecione uma cidade</option>
                                </select>
                                <input type="text" id="cidade" name="cidade" class="form-control d-none cidade-input" required>
                            </div>

                            <!--CEP/ZIP CODE-->
                            <div class="form-group col-12 col-sm-6">
                                <label class="cep" for="cep">CEP <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="cep" name="cep" placeholder="_____-___" required>
                            </div>

                            <!--Rua-->
                            <div class="form-group col-12 col-sm-6">
                                <label for="rua">Rua <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="rua" name="rua" required>
                            </div>

                            <!--Número-->
                            <div class="form-group col-12 col-sm-4">
                                <label for="numero">Número <span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>

                            <!--Complemento-->
                            <div class="form-group col-12 col-sm-8">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento">
                            </div>

                            <!--Bairro-->
                            <div class="form-group col-12 col-sm-4">
                                <label for="bairro">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro">
                            </div>

                            <div class="form-group col-12">
                                <div class="row justify-content-center">
                                    <h5 class="font-weight-bold text-center col-12 text-uppercase">Foto de perfil</h5>
                                    <div class="foto-perfil p-4">
                                        <img id="image-holder" src="view/image/no-photo.png" class="img-fluid">
                                        <a class="text-center d-block text-uppercase mt-2">Selecionar foto</a>
                                    </div>
                                </div>
                                <input id="fotoPerfil" type="file" accept="image/*" name="fotoPerfil" class="invisible">
                            </div>

                            <a class="btn-voltar btn btn-block text-uppercase col-7 col-sm-4 col-md-2 mr-auto" href="home.php"><i class="fas fa-angle-left"></i> Voltar</a>

                            <button type="submit" class="btn btn-block btn-continuar text-uppercase col-7 col-sm-4 col-md-2 p-0 m-0">Continuar <i class="fas fa-angle-right"></i></button>
                        </div>

                    </form>
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
                    <li class="list-inline-item mx-2"><a href="">Contratos de associação</a></li>
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
    <script src="view/js/cadastroSocio.js"></script>
</body>



</html>