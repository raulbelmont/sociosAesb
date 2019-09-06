<?php
require_once '../PHPMailer/PHPMailer-master/src/SMTP.php';
require_once '../PHPMailer/PHPMailer-master/src/PHPMailer.php';
    require_once '../model/autoloadController.php';
    $autoload = new autoloadController();
    $usuario = new Usuario();
    $administrador = new Administrador();
    $senha = new Senha();

function limpaCPF_CNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

function enviarEmail($email, $nome, $novaSenha){
    /*ENVIANDO E-MAIL DE CONFIRMAÇÃO AO CLIENTE*/
    $mailer = new \PHPMailer\PHPMailer\PHPMailer();
    $mailer->CharSet = "utf8";
    $mailer->SMTPDebug = false;
    $mailer->isSMTP();
    $mailer->Host="aesaoborja.com.br";
    $mailer->SMTPAuth = true;
    $mailer->Username = "contato@aesaoborja.com.br";
    $mailer->Password = "VEI&EY5FN8dL";
    $mailer->SMTPSecure = 'ssl';
    $mailer->Port = 465;
    $mailer->FromName = "Associação Esportiva São Borja.";
    $mailer->From = "contato@aesaoborja.com.br";
    //$mailer->addAddress("contatoaesb@gmail.com");
    $mailer->addAddress($email);
    $mailer->isHTML(true);
    $mailer->Subject = "Mensagem de recuperação de senha - Recebemos sua solicitação". $nome;



    $mailer->Body =
        "<strong>ASSOCIAÇÃO ESPORTIVA SÃO BORJA</strong>".
        "<p>Olá ".$nome."!</p>".
        "<p>Recebemos a sua solicitação para recuperar sua senha.</p>".
        "<h4 style='font-weight: bold;'>Essa é sua nova senha:</h4>".
        "<h1 style='margin: 5px'>$novaSenha</h1>".
        "<p style='color: #DB1F1A;'>Recomendamos fortemente que ao acessar novamente o portal de sócios você mude sua senha!</p>".
        "<p>Estamos a sua disposição, qualquer dúvida você pode entrar em contato conosco:</p>".
        "<p>Pelo telefone: (55)3431-0162</p>".
        "<p>Ou pelo E-mail: contato@aesaoborja.com.br</p>".
        "<p>Tenha um bom dia, atenciosamente <strong>Associação Esportiva São Borja.</strong></p>".
        "<strong style='margin: 5px'><i>Está mensagem é gerada automaticamente, por favor não responda.</i></strong>";

    if ($mailer->send()){
        return true;
    }else{
        return false;
    }
}

function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
    $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
    $nu = "0123456789"; // $nu contem os números
    $si = "!@#$%*_+="; // $si contem os símbolos
    $senha ='';
    if ($maiusculas){
        // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($ma);
    }

    if ($minusculas){
        // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($mi);
    }

    if ($numeros){
        // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($nu);
    }

    if ($simbolos){
        // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($si);
    }

    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
    return substr(str_shuffle($senha),0,$tamanho);
}


if (!(empty($_POST['CPF']) and empty($_POST['email']))){

    /*Tirando traços e pontos do cpf*/
    $cpf = limpaCPF_CNPJ($_POST['cpf']);

    /*pegando email*/
    $email = $_POST['email'];

    if ($usuario->recuperarSenha($cpf, $email )){

        $usuarioAtual = $usuario->recuperarSenha($cpf, $email );
        $nomeEmail = $usuarioAtual->nome.' '.$usuarioAtual->sobrenome;
        $senhaAtual = $senha->selectSenha('usuario_id',$usuarioAtual->id);

        $novaSenha = gerar_senha(8,true,true,true,true);
        $novaSenhaCriptografada = md5($novaSenha);
        $senha->setId($senhaAtual->id);
        $senha->setSenha($novaSenhaCriptografada);
        if ($senha->update()){
            if (enviarEmail($email,$nomeEmail,$novaSenha)){
                $respostaAjax = true;
                echo $respostaAjax;
            }else{
                $respostaAjax = false;
                echo $respostaAjax;
            }
        }else{
            $respostaAjax = false;
            echo $respostaAjax;
        }

    }else{
        if ($administrador->recuperarSenha($cpf, $email)){
            $usuarioAtual = $administrador->recuperarSenha($cpf, $email );
            $nomeEmail = $usuarioAtual->nome_completo;
            $senhaAtual = $senha->selectSenha('administrador_id',$usuarioAtual->id);

            $novaSenha = gerar_senha(8,true,true,true,true);
            $novaSenhaCriptografada = md5($novaSenha);
            $senha->setId($senhaAtual->id);
            $senha->setSenha($novaSenhaCriptografada);
            if ($senha->update()){
                if (enviarEmail($email, $nomeEmail, $novaSenha)){
                    $respostaAjax = true;
                    echo $respostaAjax;
                }else{
                    $respostaAjax = false;
                    echo $respostaAjax;
                }
            }else{
                $respostaAjax = false;
                echo $respostaAjax;
            }
        }else{
            $respostaAjax = false;
            echo $respostaAjax;
        }
    }

}else{
    $respostaAjax = false;
    echo $respostaAjax;
}
?>