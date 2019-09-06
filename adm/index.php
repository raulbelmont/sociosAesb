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
    <link rel="stylesheet" href="css/index.css">

    <link rel="icon" href="../view/image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../view/image/logo.png" type="image/x-icon" />

    <title>Sócios - Início</title>
</head>

<body>

    <header>
        <?php
            include 'inc/incMenu.php';
        ?>
    </header>

    <main>

        <div class="container-fluid">
            <div class="row justify-content-center py-5">

                <!--card-->
                <a class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Sócios <i class="fas fa-handshake"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a href="planos.php" class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Planos <i class="far fa-address-card"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Assinaturas <i class="fas fa-file-signature"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Contratos e políticas <i class="fas fa-file-contract"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Conteúdo <i class="fas fa-cogs"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a href="croqui.php" class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Croqui <i class="fas fa-chair"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a href="meu-perfil.php" class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Meu perfil <i class="fas fa-user"></i></h3>
                    </div>
                </a>

                <!--card-->
                <a href="administradores.php" class="col-12 col-sm-5 col-md-3 m-sm-2 d-flex align-items-center card-inicio bg-danger">
                    <div class="d-block w-100 text-center">
                        <h3 class="text-white">Administradores <i class="fas fa-user-tie"></i></h3>
                    </div>
                </a>


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
<script src="js/index.js"></script>
</body>



</html>