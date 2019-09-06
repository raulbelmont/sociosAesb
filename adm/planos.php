<?php
require_once '../model/Usuario.php';
require_once '../model/Administrador.php';
require_once '../model/Plano.php';
require_once '../model/PlanoVantagem.php';

$usuarioClass = new Usuario();
$administradorClass = new Administrador();
$planoClass = new Plano();
$planoVantagemClass = new PlanoVantagem();

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
    <link rel="stylesheet" href="css/planos.css">

    <link rel="icon" href="../view/image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../view/image/logo.png" type="image/x-icon" />

    <title>Sócios - Planos</title>
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
            <h3 class="col-12 text-center text-uppercase my-4 py-3 text-white">Planos <i class="far fa-address-card"></i></h3>
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
                <a data-toggle="modal" data-target="#modal-inserir" class="btn-salvar py-2 px-3">Cadastrar novo <i class="fas fa-plus-circle"></i></a>
            </div>
        </div>

        <!--Planos existentes-->
        <div id="row-planos" class="row justify-content-center row-planos bg-light pt-5">

            <?php foreach ($planoClass->selectAll() as $key => $value):

                /*Visibilidade*/
                if ($value->visibilidade == 1){
                    $visibilidade = "Público";
                    $classVisibilidade = "text-success";
                }else{
                    $visibilidade = "Somente administradores";
                    $classVisibilidade = "text-danger";
                }

                /*Escolha de cadeiras*/
                if ($value->isCadeira == 1){
                    $isCadeira = "Habilitada";
                    $classCadeira = "text-success";
                }else{
                    $isCadeira = "Desabilitada";
                    $classCadeira = "text-danger";
                }
            ?>
            <!--plano-->
            <div class="card p-0 m-3 plano-card col-11 col-sm-6 col-lg-3">

                <div class="card-header">
                    <h4 class="text-uppercase text-center"><?=$value->name_plan?></h4>
                </div>

                <div class="card-body p-0 pb-3 text-center">
                    <p class="my-0 pl-3 text-left">Valor da mensalidade:</p>
                    <h1 class="text-left pl-3 text-uppercase font-weight-bold my-0">R$ <?=$value->mensalidade?></h1>
                    <p class="mt-0 mb-4 pl-3 text-left">Valor da adesão: R$ <?=$value->valor_adesao?></p>

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

                    <div class="row pt-2 justify-content-center">
                        <p class="font-weight-bold col-12">Escolha de cadeiras: <span class="<?=$classCadeira?>"><?=$isCadeira?></span></p>
                        <p class="font-weight-bold col-12">Visibilidade: <span class="<?=$classVisibilidade?>"><?=$visibilidade?></span></p>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <a href="editarPlano.php?id_plano=<?=$value->id_pagarme?>" class="btn-editar py-2 px-3 m-1">Editar plano <i class="fas fa-edit"></i></a>
                </div>
            </div>

            <?php endforeach; ?>
        </div>

        <!--Modal de inserir-->
        <div class="row">
            <div class="modal fade" id="modal-inserir" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Inserir plano <i class="fas fa-plus"></i></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-cadastro" method="post" action="../controller/PlanosController.php">
                                <div id="form-row-cadastro" class="form-row justify-content-center">
                                    <!--Passando acao-->
                                    <input type="hidden" id="acao" name="acao" value="1">

                                    <!--nome-->
                                    <div class="form-group col-12">
                                        <label for="name"><i class="far fa-address-card"></i> Nome do plano *</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>

                                    <!--payment_methods-->
                                    <div class="form-group col-12">
                                        <label for="payment_methods"><i class="far fa-credit-card"></i> Métodos de pagamento aceitos *</label>
                                        <select class="form-control" id="payment_methods" name="payment_methods" required>
                                            <option value='"boleto"'>Boleto</option>
                                            <option value='"credit_card"'>Cartão de Crédito</option>
                                            <option value='"credit_card","boleto"' selected>Boleto e Cartão de Crédito</option>
                                        </select>
                                    </div>

                                    <!--visibilidade-->
                                    <div class="form-group col-12">
                                        <label for="visibilidade"><i class="fas fa-eye"></i> Visibilidade *</label>
                                        <select class="form-control" id="visibilidade" name="visibilidade" required>
                                            <option value="1" selected>Público</option>
                                            <option value="0">Somente administradores</option>
                                        </select>
                                    </div>

                                    <!--Escolha de Cadeiras-->
                                    <div class="form-group col-12">
                                        <label for="isCadeira"><i class="fas fa-chair"></i> Escolha de Cadeiras *</label>
                                        <select class="form-control" id="isCadeira" name="isCadeira" required>
                                            <option value="1" selected>Habilitada</option>
                                            <option value="0">Desabilitada</option>
                                        </select>
                                    </div>

                                    <!--valor_adesao-->
                                    <div class="form-group col-12">
                                        <label for="valor_adesao"><i class="fas fa-money-check-alt"></i> Valor de adesão *</label>
                                        <input type="text" id="valor_adesao" name="valor_adesao" class="form-control" required>
                                    </div>

                                    <!--mensalidade-->
                                    <div class="form-group col-12">
                                        <label for="mensalidade"><i class="fas fa-dollar-sign"></i> Mensalidade *</label>
                                        <input type="text" id="mensalidade" name="mensalidade" class="form-control" required>
                                    </div>

                                    <!--publico alvo-->
                                    <div class="form-group col-12 border-bottom pb-2 mb-3">
                                        <label for="publico"><i class="fas fa-users"></i> Publico alvo *</label>
                                        <textarea class="form-control" id="publico" name="publico" maxlength="255" placeholder="Explique para qual público é destinado esse plano (Máximo de 255 caractéres)" required></textarea>
                                    </div>

                                    <!--vantagens-->
                                    <div id="vantagens" class="col-12">
                                        <div class="form-group col-12 vantagem1">
                                            <label for="vantagem1">Vantagem 1</label>
                                            <textarea class="form-control" id="vantagem1" name="vantagem1" maxlength="150" placeholder="(Máximo de 150 caractéres)"></textarea>
                                        </div>
                                    </div>

                                    <input type="hidden" value="1" id="qtd-vantagens" name="qtd-vantagens">

                                    <a id="add-vantagem" class="text-success mb-3">Add vantagem <i class="fas fa-plus-circle"></i></a>
                                    <a id="remove-vantagem" class="text-danger mb-3 mt-2 mt-sm-0 ml-0 ml-sm-2">Remover vantagem <i class="fas fa-minus-circle"></i></a>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-excluir text-uppercase px-1 py-2" data-dismiss="modal">Cancelar <i class="fas fa-trash-alt"></i></button>
                                    <button type="submit" class="btn btn-salvar text-uppercase px-1 py-2">Salvar <i class="fas fa-save"></i></button>
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
<script src="js/planos.js"></script>
</body>



</html>