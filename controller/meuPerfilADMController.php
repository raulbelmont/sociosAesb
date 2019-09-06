<?php
if (!session_id()) session_start();
require_once '../model/autoloadController.php';
$autoload = new autoloadController();
$usuario = new Administrador();
$se_senha = new Senha();

function limpaCPF_CNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

/*Verificando senha*/
if (!(empty($_POST['acao'])) and $_POST['acao'] == 1){

    $id = $_POST['id'];

    $senhaAtual = $_POST['isSenhaAtual'];
    $senhaAtualCriptografada = md5($senhaAtual);

    $senhaAntiga = $se_senha->selectSenha('administrador_id', $id);

    if ($senhaAntiga->senha == $senhaAtualCriptografada){
        $ajax = true;
        echo $ajax;
    }else{
        $ajax = false;
        echo $ajax;
    }
}else{
    $ajax = false;
    echo $ajax;
}

/*Editando perfil*/
if (!(empty($_POST['acao'])) and $_POST['acao'] == 2){

    /*Dados do usuário*/
    $id = $_POST['id'];
    $nome = $_POST['nome_completo'];
    $email = $_POST['email'];
    $cpf = limpaCPF_CNPJ($_POST['cpf']);

    /*Verificando se haverá mudança de senha*/
    $senha = $_POST['senha'];
    if ($senha == 'on'){

        $usuario->setId($id);
        $usuario->setNomeCompleto($nome);
        $usuario->setEmail($email);
        $usuario->setCpf($cpf);

        if ($usuario->update()){
            $novaSenha = md5($_POST['nova_senha']);

            $ObjSenha = $se_senha->selectSenha('administrador_id', $id);

            $se_senha->setId($ObjSenha->id);
            $se_senha->setUsuarioId($ObjSenha->usuario_id);
            $se_senha->setAdministradorId($ObjSenha->administrador_id);
            $se_senha->setSenha($novaSenha);

            if ($se_senha->update()){
                $_SESSION['sucesso'] = true;
                header('location:../adm/meu-perfil.php');
            }else{
                $_SESSION['sucesso'] = false;
                header('location:../adm/meu-perfil.php');
            }
        }else{
            $_SESSION['sucesso'] = false;
            header('location:../adm/meu-perfil.php');
        }


    }else{

        $usuario->setId($id);
        $usuario->setNomeCompleto($nome);
        $usuario->setEmail($email);
        $usuario->setCpf($cpf);

        if ($usuario->update()){
            $_SESSION['sucesso'] = true;
            header('location:../adm/meu-perfil.php');
        }else{
            $_SESSION['sucesso'] = false;
            header('location:../adm/meu-perfil.php');
        }
    }

}

/*Excluindo perfil*/
if (!(empty($_POST['acao'])) and $_POST['acao'] == 3){
    var_dump($_POST);

    $id = $_POST['id'];
    $senha = md5($_POST['confirmaSenhaExclusao']);

    $senhaAtual = $se_senha->selectSenha('administrador_id',$id);
     if ($se_senha->delete($senhaAtual->id)){
         if ($usuario->delete($id)){
             session_unset();
             session_destroy();
             header('location:../home.php');
         }
     }else{
         $_SESSION['sucesso'] = false;
         header('location:../adm/meu-perfil.php');
     }
}

/*Verificando senha antiga pra exclusao*/
if (!(empty($_POST['acao'])) and $_POST['acao'] == 31){
    $id = $_POST['id'];

    $senhaAtual = $_POST['isSenhaAtual'];
    $senhaAtualCriptografada = md5($senhaAtual);

    $senhaAntiga = $se_senha->selectSenha('administrador_id', $id);

    if ($senhaAntiga->senha == $senhaAtualCriptografada){
        $ajax = true;
        echo $ajax;
    }else{
        $ajax = false;
        echo $ajax;
    }
}else{
    $ajax = false;
    echo $ajax;
}