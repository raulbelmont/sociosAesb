<?php
require_once '../model/Usuario.php';
require_once '../model/Administrador.php';

$usuarioClass = new Usuario();
$administradorClass = new Administrador();

/*Verificando logout*/
if (!empty($_GET['sair']) and $_GET['sair'] == true ){
    if (!session_id()) session_start();
    session_unset();
    session_destroy();
    header('Location:../home.php');
}else{

}

/*Verificando login e defiindo usuario*/
if (!session_id()) session_start();
if ($_SESSION['isLogado'] == true){
    if ($_SESSION['user_type'] == 'usuario'){
        $usuario = $usuarioClass->select($_SESSION['user_id']);
    }else{
        if ($_SESSION['user_type'] == 'administrador'){
            $usuario = $administradorClass->select($_SESSION['user_id']);
        }else{
            header('Location:../home.php');
        }
    }
}else{
    header('Location:../home.php');
}
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="css/meu-perfil.css">

    <link rel="icon" href="../view/image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../view/image/logo.png" type="image/x-icon" />

    <title>Sócios - Meu Perfil</title>
</head>

<body>

<header>
    <?php
    include 'inc/incMenu.php';
    ?>
</header>

<main>
    <div class="container-fluid">

        <!--Título-->
        <div class="row justify-content-center">
            <h1 class="col-10 border-bottom py-3 my-3 text-center text-uppercase">Meu perfil <i class="fas fa-user"></i></h1>
        </div>

        <!--Mensagem-->
        <div class="row">
            <!--Sucesso-->
            <?php if (isset($_SESSION['sucesso']) and $_SESSION['sucesso'] == true){ ?>
                <div class="mensagem-de-sucesso col-12 p-2 my-2 text-center justify-content-center d-block">
                    <h2 class="text-success font-weight-bold">Sucesso <i class="fas fa-check-circle"></i></h2>
                </div>
            <?php } $_SESSION['sucesso'] = null; ?>

            <!--Sucesso-->
            <?php if (isset($_SESSION['sucesso']) and $_SESSION['sucesso'] == false){ ?>
                <div class="mensagem-de-erro col-12 p-2 my-2 text-center justify-content-center d-block">
                    <h2 class="text-danger font-weight-bold">Algo deu errado. Tente novamente mais tarde <i class="fas fa-times-circle"></i></h2>
                </div>
            <?php } $_SESSION['sucesso'] = null; ?>

        </div>

        <!--perfil-->
        <div class="row justify-content-center py-5">
            <div class="card col-11 col-md-8 col-lg-6 card-info">
                <div class="card-img-top text-center my-2">
                    <i class="fas fa-id-card fa-5x"></i>
                </div>
                <ul class="list-group list-group-flush my-4">
                    <li class="list-group-item"><strong><i class="fas fa-user"></i> Nome Completo:</strong> <input class="form-control" type="text" placeholder="<?=$usuario->nome_completo?>" readonly></li>
                    <li class="list-group-item"><strong><i class="fas fa-envelope"></i> E-mail: </strong> <input class="form-control" type="text" placeholder="<?=$usuario->email?>" readonly></li>
                    <li class="list-group-item"><strong><i class="fas fa-address-book"></i> Cpf: </strong> <input id="cpfRead" class="form-control" type="text" value="<?=$usuario->cpf?>" readonly></li>
                    <li class="list-group-item"><strong><i class="fas fa-key"></i> Senha: </strong> <input class="form-control" type="password" placeholder="" value="senhauser" readonly></li>
                </ul>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <a data-toggle="modal" data-target="#modal-excluir" class="col-12 col-sm-5 col-md-auto card-link btn-excluir text-uppercase m-0 px-3 py-2">Excluir <i class="fas fa-user-times"></i></a>
                        <a data-toggle="modal" data-target="#modal-editar" class="col-12 col-sm-5 col-md-auto card-link btn-editar text-uppercase m-0 mt-2 mt-sm-0 ml-sm-2 px-3 py-2">Editar <i class="fas fa-user-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal editar -->
        <div class="row">
            <div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar <i class="fas fa-user-edit"></i></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-editar" method="post" action="../controller/meuPerfilADMController.php">
                                <div class="form-row justify-content-center">
                                    <!--Passando ID-->
                                    <input type="hidden" id="id" name="id" value="<?=$usuario->id?>">
                                    <input type="hidden" id="acao" name="acao" value="2">

                                    <!--nome-->
                                    <div class="form-group col-12">
                                        <label for="nome_completo"><i class="fas fa-user"></i> Nome completo *</label>
                                        <input type="text" id="nome_completo" name="nome_completo" value="<?=$usuario->nome_completo?>" class="form-control" required>
                                    </div>

                                    <!--email-->
                                    <div class="form-group col-12">
                                        <label for="email"><i class="fas fa-envelope"></i> E-mail *</label>
                                        <input type="text" id="email" name="email" value="<?=$usuario->email?>" class="form-control" required>
                                    </div>

                                    <!--CPF-->
                                    <div class="form-group col-12">
                                        <label for="cpf"><i class="fas fa-address-book"></i> CPF *</label>
                                        <input type="text" id="cpf" name="cpf" value="<?=$usuario->cpf?>" class="form-control" required>
                                    </div>

                                    <!--Mudar senha-->
                                    <div class="form-check col-12 col-sm-6 pl-3">
                                        <input type="radio" class="form-check-input" name="senha" id="mudar-senha">
                                        <label class="form-check-label" for="exampleCheck1">Mudar senha</label>
                                    </div>

                                    <!--Manter senha-->
                                    <div class="form-check col-12 col-sm-6 pl-3 mb-3">
                                        <input type="radio" class="form-check-input" name="senha" id="manter-senha">
                                        <label class="form-check-label" for="exampleCheck1">Manter senha</label>
                                    </div>

                                    <!--Senha atual-->
                                    <div class="form-group col-12 py-3 border-top border-bottom d-none senha">
                                        <label for="senha_atual"><i class="fas fa-key"></i> Digite sua senha atual * <i id="spin-senha" class="fas fa-sync-alt fa-spin fa-fw d-none"></i></label>
                                        <p class="col-12 text-danger d-none msg-incorreta">Senha incorreta!</p>
                                        <input type="password" id="senha_atual" name="senha_atual" class="form-control">
                                    </div>

                                    <!--Nova senha-->
                                    <div class="form-group col-12 d-none nova-senha">
                                        <label for="nova_senha">Nova senha * <i class="fas fa-key"></i></label>
                                        <input type="password" id="nova_senha" name="nova_senha" class="form-control">
                                        <table id="mostra"></table>
                                    </div>

                                    <!--Confirmar senha-->
                                    <div class="form-group col-12 d-none confirmar-senha">
                                        <label for="confirmar_senha">Digite novamente * <i class="fas fa-key"></i></label>
                                        <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control">
                                    </div>

                                    <p class="col-12 text-success d-none msg-senhas-iguais">Ok!</p>
                                    <p class="col-12 text-danger d-none msg-senhas-diferentes">As senhas devem ser iguais!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-excluir text-uppercase px-1 py-2" data-dismiss="modal">Cancelar <i class="fas fa-trash-alt"></i></button>
                                    <button type="button" class="btn btn-submit-editar btn-salvar text-uppercase px-1 py-2 disabled">Salvar <i class="fas fa-save"></i></button>
                                    <button type="submit" class="btn btn-submit-editar-real btn-salvar text-uppercase px-3 py-2 d-none">Salvar <i class="fas fa-save"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal excluir-->
        <div class="row">
            <div class="modal fade" id="modal-excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Excluir <i class="fas fa-user-times"></i></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-excluir" action="../controller/meuPerfilADMController.php" method="post">
                                <input type="hidden" id="idExclusao" name="id" value="<?=$usuario->id?>">
                                <input type="hidden" id="acao" name="acao" value="3">

                                <h3 class="text-danger col-12">Você tem certeza que deseja excluir sua conta?</h3>

                                <label for="confirmaSenhaExclusao">Para continuar digite sua senha <i id="spin-senha-exclusao" class="fas fa-sync-alt fa-spin fa-fw d-none"></i></label>
                                <input type="password" class="form-control" name="confirmaSenhaExclusao" id="confirmaSenhaExclusao" required>

                                <h5 class="text-danger msg-senha-excluir d-none">Senha incorreta!</h5>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-excluir text-uppercase px-1 py-2" data-dismiss="modal">Cancelar <i class="fas fa-times"></i></button>
                                    <button type="button" class="btn btn-salvar btn-submit-excluir text-uppercase px-1 py-2">Excluir <i class="fas fa-trash-alt"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</main>

<footer>
    <?php
    include 'inc/incRodape.php';
    ?>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/meu-perfil.js"></script>
</body>



</html>
