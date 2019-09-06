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

/*Verificando exclusão de usuário*/
if (!(empty($_GET['excluir']))){
    $_SESSION['excluir'] = $_GET['excluir'];
    header('Location:../controller/administradoresController.php?acao=3');
}

?>
<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="css/administradores.css">

    <link rel="icon" href="../view/image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../view/image/logo.png" type="image/x-icon" />

    <title>Sócios - Administradores</title>
</head>

<body>

<header>
    <?php
    include 'inc/incMenu.php';
    ?>
</header>

<main>

    <div class="container-fluid">
        <!--Administradores-->

        <div class="row bg-dark">
            <h3 class="col-12 text-center text-uppercase my-4 py-3 text-white">Administradores <i class="fas fa-user-tie"></i></h3>
        </div>

        <!--Mensagem-->
        <div class="row bg-light">
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
        <div class="row justify-content-center py-5 bg-light card-info">
            <div class="col-12 text-center mb-3">
                <a data-toggle="modal" data-target="#modal-inserir" class="btn-salvar py-2 px-3">Cadastrar novo <i class="fas fa-user-plus"></i></a>
            </div>
            <?php foreach ($administradorClass->selectAll() as $key => $value):
                if ($value->id != $usuario->id){
            ?>
            <div class="card col-11 col-md-6 col-lg-3 m-3">
                <div class="card-img-top text-center">
                    <i class="fas fa-id-card fa-5x"></i>
                    <h5 class="text-center"><?=$value->nome_completo?></h5>
                </div>
                <ul class="list-group list-group-flush my-2">
                    <li class="list-group-item"><strong><i class="fas fa-user"></i> Nome Completo:</strong> <input class="form-control" type="text" placeholder="<?=$value->nome_completo?>" readonly></li>
                    <li class="list-group-item"><strong><i class="fas fa-envelope"></i> E-mail: </strong> <input class="form-control" type="text" placeholder="<?=$value->email?>" readonly></li>
                    <li class="list-group-item"><strong><i class="fas fa-address-book"></i> Cpf: </strong> <input id="cpfRead" class="form-control cpfread" type="text" value="<?=$value->cpf?>" readonly></li>
                </ul>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <a href="?excluir=<?=$value->id?>" class="col-12 col-sm-5 col-md-auto card-link btn-excluir text-uppercase m-0 px-3 py-2">Excluir <i class="fas fa-user-times"></i></a>
                    </div>
                </div>
            </div>
            <?php } endforeach; ?>
        </div>

        <!--Modal de inserir-->
        <div class="row">
            <div class="modal fade" id="modal-inserir" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Inserir <i class="fas fa-user-plus"></i></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-cadastro" method="post" action="../controller/administradoresController.php">
                                <div class="form-row justify-content-center">
                                    <!--Passando ID-->
                                    <input type="hidden" id="acao" name="acao" value="1">

                                    <!--nome-->
                                    <div class="form-group col-12">
                                        <label for="nome_completo"><i class="fas fa-user"></i> Nome completo *</label>
                                        <input type="text" id="nome_completo" name="nome_completo" class="form-control" required>
                                    </div>

                                    <!--email-->
                                    <div class="form-group col-12">
                                        <label for="email"><i class="fas fa-envelope"></i> E-mail *</label>
                                        <input type="text" id="email" name="email" class="form-control" required>
                                    </div>

                                    <!--CPF-->
                                    <div class="form-group col-12">
                                        <label for="cpf"><i class="fas fa-address-book"></i> CPF * <i id="spin-cpf" class="fas fa-sync-alt fa-spin fa-fw d-none"></i></label>
                                        <input type="text" id="cpf" name="cpf" class="form-control" required>
                                    </div>

                                    <p class="text-danger cpf-erro d-none">CPF já cadastrado!</p>
                                    <p class="text-success cpf-sucesso d-none">CPF disponível</p>

                                    <!--Nova senha-->
                                    <div class="form-group col-12">
                                        <label for="nova_senha">Nova senha * <i class="fas fa-key"></i></label>
                                        <input type="password" id="nova_senha" name="nova_senha" class="form-control">
                                        <table id="mostra"></table>
                                    </div>

                                    <!--Confirmar senha-->
                                    <div class="form-group col-12">
                                        <label for="confirmar_senha">Digite novamente * <i class="fas fa-key"></i></label>
                                        <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control">
                                    </div>

                                    <p class="col-12 text-success d-none msg-senhas-iguais">Ok!</p>
                                    <p class="col-12 text-danger d-none msg-senhas-diferentes">As senhas devem ser iguais!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-excluir text-uppercase px-1 py-2" data-dismiss="modal">Cancelar <i class="fas fa-trash-alt"></i></button>
                                    <button type="submit" class="btn btn-novo-user btn-salvar text-uppercase px-1 py-2 disabled">Salvar <i class="fas fa-save"></i></button>
                                </div>
                            </form>
                        </div>
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
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/administradores.js"></script>
</body>



</html>