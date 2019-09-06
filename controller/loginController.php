<?php

require_once '../model/autoloadController.php';
$autoload = new autoloadController();
$loginModel = new LoginModel();
$usuario = new Usuario();
$administrador = new Administrador();

function limpaCPF_CNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

/*Verificando se cpf e senha estão preenchidos*/
if ((!empty($_POST['cpf'])) and (!empty($_POST['senha']))) {

    /*Tirando traços e pontos do cpf*/
    $cpf = limpaCPF_CNPJ($_POST['cpf']);

    /*criptografando senha*/
    $senha = md5($_POST['senha']);

    /*Efetuando login*/
    if ($loginModel->login($cpf,$senha)){

        /*redirecionando usuario*/
        if ($usuario->selectCPF($cpf)){
            $url = 'socio/index.php';
            echo $url;
        }else{
            if ($administrador->selectCPF($cpf)){
                $url = 'adm/index.php';
                echo $url;
            }else{
                $url = false;
                echo $url;
            }
        }
    }else{
        $url = false;
        echo $url;
    }
}else{
    $url = false;
    echo $url;
}