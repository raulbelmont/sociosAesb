<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 26/01/2019
 * Time: 09:45
 */


require_once '../model/autoloadController.php';
$autoload = new autoloadController();
$estados = new Estado();
$cidades = new Cidade();

if (!(empty($_POST['estado']))){

    $sigla = $_POST['estado'];

    $estado = $estados->selectEstado($sigla);
    $estado_id = $estado->id;


    foreach ($cidades->selectCidades($estado_id) as $key => $value){
        echo "<option value='$value->nome'>$value->nome</option>";
    }



}