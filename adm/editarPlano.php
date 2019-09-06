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

if (!empty($_GET['id_plano'])){
    $id_plano = $_GET['id_plano'];
    $value = $planoClass->selectByIDPGM($id_plano);
}else{

    header('Location:index.php');

}


?>
<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="css/editarPlano.css">

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
            <h3 class="col-12 text-center text-uppercase my-4 py-3 text-white"><i class="fas fa-edit"></i> Editar plano "<?=$value->name_plan?>"</h3>
        </div>

        <!---->
        <?php

            /*definindo select de visibilidade*/
            if ($value->visibilidade == '1'){
                $selectedAdm = '';
                $selectedPub = 'selected';
            }else{
                $selectedAdm = 'selected';
                $selectedPub = '';
            }

            /*definindo select de cadeira*/
            if ($value->isCadeira == '1'){
                $selectedHab = 'selected';
                $selectedDes = '';
            }else{
                $selectedHab = '';
                $selectedDes = 'selected';
            }

            ?>
            <div class="row justify-content-center my-5 py-5 bg-light">
                <div class="col-12 col-sm-8">
                    <form id="form-editar" method="post" enctype="multipart/form-data" action="../controller/PlanosController.php">

                        <div class="form-row justify-content-center">
                            <input type="hidden" id="id" name="id" value="<?=$value->id?>" required>
                            <input type="hidden" id="id_plano" name="id_plano" value="<?=$value->id_pagarme?>" required>
                            <input type="hidden" id="acao" name="acao" value="2" required>

                            <!--Nome do plano-->
                            <div class="form-group col-12">
                                <label for="name_plan">Nome *</label>
                                <input type="text" id="name_plan-editar" name="name_plan" class="form-control" value="<?=$value->name_plan?>" required>
                            </div>

                            <!--Valor adesão-->
                            <div class="form-group col-12">
                                <label for="valor_adesao">Valor de adesão *</label>
                                <input type="text" id="valor_adesao_editar" name="valor_adesao" class="form-control" value="<?=$value->valor_adesao?>" required>
                            </div>

                            <!--visibilidade-->
                            <div class="form-group col-12">
                                <label for="visibilidade"><i class="fas fa-eye"></i> Visibilidade *</label>
                                <select class="form-control" id="visibilidade-editar" name="visibilidade" required>
                                    <option value="1" <?=$selectedPub?>>Público</option>
                                    <option value="0" <?=$selectedAdm?>>Somente administradores</option>
                                </select>
                            </div>

                            <!--Escolha de Cadeiras-->
                            <div class="form-group col-12">
                                <label for="isCadeira"><i class="fas fa-chair"></i> Escolha de Cadeiras *</label>
                                <select class="form-control" id="isCadeira-editar" name="isCadeira" required>
                                    <option value="1" <?=$selectedHab?>>Habilitada</option>
                                    <option value="0" <?=$selectedDes?>>Desabilitada</option>
                                </select>
                            </div>

                            <!--publico alvo-->
                            <div class="form-group col-12 border-bottom pb-2 mb-3">
                                <label for="publico-editar"><i class="fas fa-users"></i> Publico alvo *</label>
                                <textarea class="form-control" id="publico-editar" name="publico" maxlength="255" placeholder="Explique para qual público é destinado esse plano (Máximo de 255 caractéres)" required><?=$value->publico?></textarea>
                            </div>

                            <!--vantagens-->
                            <div id="vantagens-editar" class="col-12">
                                <?php $cont = 1; foreach ($planoVantagemClass->selectByPlano($value->id) as $key => $valueVantagem): ?>
                                    <div class="form-group col-12 vantagem-editar<?=$cont?>">
                                        <label for="vantagem<?=$cont?>">Vantagem <?=$cont?></label>
                                        <textarea class="form-control" id="vantagem<?=$cont?>" name="vantagem<?=$cont?>" maxlength="150" placeholder="(Máximo de 150 caractéres)"><?=$valueVantagem->vantagem?></textarea>
                                    </div>
                                    <?php $cont++; endforeach; $cont = $cont-1;?>
                            </div>

                            <input type="hidden" value="<?=$cont?>" id="qtd-vantagens-editar" name="qtd-vantagens">

                            <a id="add-vantagem-editar" class="text-success mb-3">Add vantagem <i class="fas fa-plus-circle"></i></a>
                            <a id="remove-vantagem-editar" class="text-danger mb-3 mt-2 mt-sm-0 ml-0 ml-sm-2">Remover vantagem <i class="fas fa-minus-circle"></i></a>

                            <div class="form-group col-12">
                                <div class="row justify-content-center text-center">
                                    <a href="planos.php" class="btn-excluir py-2 px-3 m-3 col-10 col-sm-3">Cancelar <i class="fas fa-trash"></i></a>
                                    <button type="submit" class="btn-salvar py-2 px-3 m-3 col-10 col-sm-3">Salvar <i class="fas fa-save"></i></button>
                                </div>

                            </div>

                        </div>

                    </form>
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
<script src="js/editarPlano.js"></script>
</body>



</html>