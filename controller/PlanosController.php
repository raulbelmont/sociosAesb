<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 04/02/2019
 * Time: 15:28
 */
if (!session_id()) session_start();
date_default_timezone_set('America/Sao_Paulo');

require '../vendor/autoload.php';
require_once '../model/autoloadController.php';

$pagarme = new \PagarMe\Sdk\PagarMe('ak_test_GgcjB8cnc78bOEw4hq1HigrGDGfkND');
$autoload = new autoloadController();
$planoClass = new Plano();
$planoVantagemClass = new PlanoVantagem();


function limpaCPF_CNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}


/*Inserindo plano*/
if (!empty($_POST['acao']) and $_POST['acao'] == 1){


    /*informeções para pagarME*/
    $name = $_POST['name'];
    $payment_methods = $_POST['payment_methods'];
    $amount = limpaCPF_CNPJ($_POST['mensalidade']);
    $days = 365;
    $charges = null;
    $installments = 12;
    $invoice_reminder = 2;
    $trialDays = 0;


   if ($plan = $pagarme->plan()->create(
       $amount,
       $days,
       $name,
       $trialDays,
       $payment_methods,
       $charges,
       $installments,
       $invoice_reminder
   )){

       /*Informações para o sistema local*/
       $amountLocal = $plan->getAmount();
       $daysLocal = $plan->getDays();
       $nameLocal = $plan->getName();
       $chargesLocal = $plan->getCharges();
       $installmentsLocal = $plan->getInstallments();
       $invoice_reminderLocal = $plan->getInvoiceReminder();
       $date_createdLocal = date('Y-m-d H:i');
       $valor_adesaoLocal = $_POST['valor_adesao'];
       $visibilidadeLocal = $_POST['visibilidade'];
       $mensalidadeLocal = $_POST['mensalidade'];
       $publicoLocal = $_POST['publico'];
       $isCadeiralocal = $_POST['isCadeira'];
       $id_pagarmeLocal = $plan->getId();

       $planoClass->setAmount($amountLocal);
       $planoClass->setDays($daysLocal);
       $planoClass->setName($nameLocal);
       $planoClass->setPaymentMethods($payment_methods);
       $planoClass->setInstallments($installmentsLocal);
       $planoClass->setInvoiceReminder($invoice_reminderLocal);
       $planoClass->setDateCreated($date_createdLocal);
       $planoClass->setValorAdesao($valor_adesaoLocal);
       $planoClass->setVisibilidade($visibilidadeLocal);
       $planoClass->setMensalidade($mensalidadeLocal);
       $planoClass->setPublico($publicoLocal);
       $planoClass->setIsCadeira($isCadeiralocal);
       $planoClass->setIdPagarme($id_pagarmeLocal);

       if ($planoClass->insert()){

           $planoInserido = $planoClass->selectByIDPGM($id_pagarmeLocal);

           $qtdVantagens = $_POST['qtd-vantagens'];
           $vantagens = [];

           for ($cont = 1; $cont<=$qtdVantagens; $cont++){
               array_push($vantagens,$_POST['vantagem'.$cont]);
           }

           $success = 0;
           foreach ($vantagens as &$value){
                $planoVantagemClass->setPlanoId($planoInserido->id);
                $planoVantagemClass->setVantagem($value);

                /*inserindo vantagens no bd*/
                if ($planoVantagemClass->insert()){
                    $success = $success + 1;
                }else{
                    $success = $success - 1;
                }
           }

           /*testando se todas as vantagens foram inseridas*/
           if ($success == $qtdVantagens){
               $_SESSION['sucesso'] = true;
               header('location:../adm/planos.php');
           }else{
               $_SESSION['sucesso'] = false;
               header('location:../adm/planos.php');
           }


       }else{
           $_SESSION['sucesso'] = false;
           header('location:../adm/planos.php');
       }

   }else{

       $_SESSION['sucesso'] = false;
       header('location:../adm/planos.php');
   }




}

/*editando plano*/
if (!empty($_POST['acao']) and $_POST['acao'] == 2){

    $id = $_POST['id'];
    $planoAesbBD = $planoClass->select($id);
    $id_pagarme = $_POST['id_plano'];
    $name_plan = $_POST['name_plan'];
    $valor_adesao = $_POST['valor_adesao'];
    $visibilidade = $_POST['visibilidade'];
    $isCadeira = $_POST['isCadeira'];
    $publico = $_POST['publico'];
    $qtdVantagens = $_POST['qtd-vantagens'];

    $planoAtualPagarme = $pagarme->plan()->get($id_pagarme);
    $planoAtualPagarme->setName($name_plan);

    /*Atualizado plano na pagarme*/
    if ($planoAtualizado = $pagarme->plan()->update($planoAtualPagarme)){
        $planoClass->setId($id);
        $planoClass->setAmount($planoAtualizado->getAmount());
        $planoClass->setDays($planoAtualizado->getDays());
        $planoClass->setName($planoAtualizado->getName());
        $planoClass->setPaymentMethods($planoAesbBD->payment_methods);
        $planoClass->setCharges($planoAtualizado->getCharges());
        $planoClass->setInstallments($planoAtualizado->getInstallments());
        $planoClass->setInvoiceReminder($planoAtualizado->getInvoiceReminder());
        $planoClass->setDateCreated($planoAesbBD->date_created);
        $planoClass->setValorAdesao($valor_adesao);
        $planoClass->setVisibilidade($visibilidade);
        $planoClass->setMensalidade($planoAesbBD->mensalidade);
        $planoClass->setPublico($publico);
        $planoClass->setIsCadeira($isCadeira);
        $planoClass->setIdPagarme($planoAtualizado->getId());

        /*Atualizando plano no bd da aesb*/
        if ($planoClass->update()){

            /*Excluindo vantagens antigas*/
           if ($planoVantagemClass->deleteByPlano($id)){

               $vantagens = [];

               for ($cont = 1; $cont<=$qtdVantagens; $cont++){
                   array_push($vantagens,$_POST['vantagem'.$cont]);
               }

               $success = 0;
               foreach ($vantagens as &$value){
                   $planoVantagemClass->setPlanoId($id);
                   $planoVantagemClass->setVantagem($value);

                   /*inserindo vantagens no bd*/
                   if ($planoVantagemClass->insert()){
                       $success = $success + 1;
                   }else{
                       $success = $success - 1;
                   }
               }

               /*testando se todas as vantagens foram inseridas*/
               if ($success == $qtdVantagens){
                   $_SESSION['sucesso'] = true;
                   header('location:../adm/planos.php');
               }else{
                   $_SESSION['sucesso'] = false;
                   header('location:../adm/planos.php');
               }


           }else{
               $_SESSION['sucesso'] = false;
               header('location:../adm/planos.php');
           }

        }else{
            $_SESSION['sucesso'] = false;
            header('location:../adm/planos.php');
        }

    }else{
        $_SESSION['sucesso'] = false;
        header('location:../adm/planos.php');
    }

}

