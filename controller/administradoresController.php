<?php
if (!session_id()) session_start();
    require_once '../model/autoloadController.php';
    $autoload = new autoloadController();
    $admClass = new Administrador();
    $se_senha = new Senha();

    function limpaCPF_CNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

    /*Cadastrar usuário*/
    if (!(empty($_POST['acao'])) and $_POST['acao'] == 1){

        $nome = $_POST['nome_completo'];
        $email = $_POST['email'];
        $cpf = limpaCPF_CNPJ($_POST['cpf']);
        $senha = md5($_POST['nova_senha']);

        $admClass->setCpf($cpf);
        $admClass->setEmail($email);
        $admClass->setNomeCompleto($nome);

        /*Cadstro de user*/
        if ($admClass->insert()){
            $userCadastrado = $admClass->selectCPF($cpf);

            $se_senha->setAdministradorId($userCadastrado->id);
            $se_senha->setSenha($senha);

            /*Cadastro de senha*/
            if ($se_senha->insert()){
                $_SESSION['sucesso'] = true;
                header('location:../adm/administradores.php');
            }else{
                $_SESSION['sucesso'] = false;
                header('location:../adm/administradores.php');
            }
        }else{
            $_SESSION['sucesso'] = false;
            header('location:../adm/administradores.php');
        }
    }

    /*Verificando existencia do CPF*/
    if(!(empty($_POST['acao'])) and $_POST['acao'] == 11){
        $cpf = limpaCPF_CNPJ($_POST['cpfVerifica']);

        if ($admClass->selectCPF($cpf)){
            $ajax = false;
            echo $ajax;
        }else{
            $ajax = true;
            echo $ajax;
        }
    }

    /*Excluindo ADM*/
    if (!(empty($_GET['acao'])) and $_GET['acao'] == 3){
        $idAdm = $_SESSION['excluir'];

        $senhaAdm = $se_senha->selectSenha('administrador_id',$idAdm);

        if ($se_senha->delete($senhaAdm->id)){
            if ($admClass->delete($idAdm)){
                $_SESSION['excluir'] = null;
                $_SESSION['sucesso'] = true;
                header('location:../adm/administradores.php');
            }else{
                $_SESSION['excluir'] = null;
                $_SESSION['sucesso'] = false;
                header('location:../adm/administradores.php');
            }
        }else{
            $_SESSION['excluir'] = null;
            $_SESSION['sucesso'] = false;
            header('location:../adm/administradores.php');
        }

    }
?>