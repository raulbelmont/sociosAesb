<?php
require_once '../model/Usuario.php';
require_once '../model/Administrador.php';
require_once '../model/Cadeira.php';
require_once '../model/Bloco_cadeira.php';

$usuarioClass = new Usuario();
$administradorClass = new Administrador();
$blocoCadeiraClass = new Bloco_cadeira();
$cadeiraClass = new Cadeira();

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
    <link rel="stylesheet" href="css/croqui.css">

    <link rel="icon" href="../view/image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../view/image/logo.png" type="image/x-icon" />

    <title>Sócios - Editar plano</title>
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
        <div class="row bg-dark">
            <h3 class="col-12 text-center text-uppercase my-4 py-3 text-white">Croqui <i class="fas fa-chair"></i></h3>
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


        <!--BTN novo plano-->
        <div class="row justify-content-center py-5">
            <div class="col-12 text-center mb-3">
                <a data-toggle="modal" data-target="#modal-inserir" class="btn-salvar py-2 px-3">Cadastrar bloco <i class="fas fa-plus-circle"></i></a>
            </div>
        </div>

        <!--Blocos-->
        <div class="row justify-content-center py-3 bg-light">

            <?php foreach ($blocoCadeiraClass->selectAll() as $key => $value): ?>
            <a href="#cadeira-bloco<?=$value->id?>" id="<?=$value->id?>" class="bloco scroll col-11 col-sm-9 col-md-5 col-lg-3 m-3">
                <h4 class="text-center text-white"><i class="fas fa-th-large"></i> Bloco "<?=$value->nome?>"</h4>
            </a>
            <?php endforeach; ?>

        </div>


        <!--Cadeiras/bloco-->
        <?php $cont = 0;  foreach ($blocoCadeiraClass->selectAll() as $key => $value):
            if ($cont == 0){
                $displayThis = 'ativo';
            }else{
                $displayThis = 'fade';
            }

            if ($cont % 2 == 0){
                $thisBG = 'bg-dark-50';
            }else{
                $thisBG = 'bg-dark-100';
            }
        ?>


        <!--Cadeiras/Bloco-->
        <div id="cadeira-bloco<?=$value->id?>" class="row justify-content-center cadeira-bloco <?=$displayThis?> py-3 <?=$thisBG?> text-white">

            <h4 class="text-center text-white col-12">Cadeiras do bloco <span class="bg-cadeira-vazia">"<?=$value->nome?>"</span></h4>

            <!--legenda-->
            <div class="legenda text-white col-12 my-5">
                <div class="row justify-content-center">
                    <p class="col-12 text-center my-1 text-uppercase font-weight-bold">Legenda:</p>
                    <p class="col-12 col-sm-6 col-md-3 text-center my-2">Cadeira cativa: <span class="bg-cadeira-cativa p-1"><i class="fas fa-chair"></i></span></p>
                    <p class="col-12 col-sm-6 col-md-3 text-center my-2">Cadeira vazia: <span class="bg-cadeira-vazia p-1"><i class="fas fa-chair"></i></span></p>
                    <p class="col-12 col-sm-6 col-md-3 text-center my-2">Cadeira reservada: <span class="bg-cadeira-reservada p-1"><i class="fas fa-chair"></i></span></p>
                    <p class="col-12 col-sm-6 col-md-3 text-center my-2">Cadeira cativa reservada: <span class="bg-cadeira-cativa-reservada p-1"><i class="fas fa-chair"></i></span></p>
                </div>
            </div>

            <!--Cadeiras-->

            <h4 class="text-center text-white col-12 my-5">Cadeiras <i class="fas fa-chair"></i></h4>


            <!--Cadeira-->
            <div class="col-12 mb-5">
                <div class="row">
                    <?php foreach ($cadeiraClass->selectByBloco($value->id) as $key => $valueCadeira):

                        if (($valueCadeira->isReservada == 1) and ($valueCadeira->nome_cadeira == null)){
                            $thisBG = 'bg-cadeira-reservada';
                        }

                        if (($valueCadeira->isReservada == 1) and ($valueCadeira->nome_cadeira != null)){
                            $thisBG = 'bg-cadeira-cativa-reservada';
                        }

                        if (($valueCadeira->isReservada == 0) and ($valueCadeira->nome_cadeira == null)){
                            $thisBG = 'bg-cadeira-vazia';
                        }

                        if (($valueCadeira->isReservada == 0) and ($valueCadeira->nome_cadeira != null)){
                            $thisBG = 'bg-cadeira-cativa';
                        }
                        ?>

                        <!--cadeira-->
                        <a id="<?=$valueCadeira->id?>" data-toggle="modal" data-target="#modal-cadeira<?=$valueCadeira->id?>" class="col-4 col-sm-3 col-md-2 col-lg-1">
                            <h4 class="text-center cadeira text-white <?=$thisBG?>"><?=$valueCadeira->numero_cadeira?></h4>
                        </a>

                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-12">
                <div class="row justify-content-center text-center">
                    <a class="col-12 col-sm-5 col-md-4 col-lg-2 py-2 px-3 btn-editar mx-2">Editar bloco <i class="fas fa-edit"></i></a>
                    <a class="col-12 col-sm-5 col-md-4 col-lg-2 py-2 px-3 btn-excluir mx-2">Excluir bloco <i class="fas fa-trash"></i></a>
                </div>
            </div>



        </div>
        <?php $cont++; endforeach; ?>


        <!--Modais de cadeiras-->
        <?php foreach ($blocoCadeiraClass->selectAll() as $key => $value): ?>
            <?php foreach ($cadeiraClass->selectByBloco($value->id) as $key => $valueCadeira):  ?>

                <!--Modais para cadeiras vazias-->
                <?php if (($valueCadeira->isReservada == 0) and ($valueCadeira->nome_cadeira == null)){ ?>
                <!-- Modal -->
                <div class="modal fade" id="modal-cadeira<?=$valueCadeira->id?>" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-chair"></i> Cadeira número <?=$valueCadeira->numero_cadeira?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-danger font-weight-bold text-center">Cadeira vazia</h5>

                                <div class="row my-2 justify-content-center">
                                    <a id="<?=$valueCadeira->id?>" class="col-12 col-sm-5 m-2 py-2 px-3 btn-editar">Reservar cadeira</a>
                                    <a href="?cadeiraExcluir=<?=$valueCadeira->id?>" class="col-12 col-sm-5 m-2 py-2 px-3 btn-excluir">Excluir cadeira <i></i></a>
                                </div>

                                <div class="form-reservar<?=$valueCadeira->id?> col-12 mt-2 pt-2 border-top">
                                    <p class="text-center">Reservar cadeira</p>

                                    <form id="reservar-cadeira<?=$valueCadeira->id?>" method="post" action="../controller/croquiController.php">
                                        <div class="form-row">

                                            <input type="hidden" name="id_cadeira" value="<?=$valueCadeira->id?>">
                                            <input type="acao" name="acao" value="reservarCadeira">

                                            <label for="nome_cadeira">Nome do Ocupante:</label>
                                            <input type="text" class="form-control" id="nome_cadeira" name="nome_cadeira" required>

                                            <a id="cancelar-reserva<?=$valueCadeira->id?>" class="btn-excluir py-2 px-3 m-2">Cancelar</a>
                                            <button type="submit" class="btn-salvar py-2 px-3 m-2">Reservar</button>
                                        </div>
                                    </form>

                                </div>



                            </div>
                        </div>
                    </div>
                </div>

            <?php } endforeach; ?>
        <?php endforeach;?>
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
<script src="js/croqui.js"></script>
</body>



</html>