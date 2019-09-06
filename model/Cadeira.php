<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 26/01/2019
 * Time: 16:20
 */
require_once 'CRUD.php';
class Cadeira extends CRUD
{
    private $id; //bigint
    private $numero_cadeira; //int
    private $nome_cadeira; //varchar
    private $bloco_cadeira_id; //bigint

    protected $table = "cadeira";

    public function insert()
    {
        $sql = "INSERT INTO $this->table (numero_cadeira, nome_cadeira, bloco_cadeira_id) VALUES (:numero_cadeira, :nome_cadeira, :bloco_cadeira_id)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':numero_cadeira',$this->numero_cadeira, PDO::PARAM_INT);
        $stmt->bindParam(':nome_cadeira',$this->nome_cadeira, PDO::PARAM_STR);
        $stmt->bindParam(':bloco_cadeira_id',$this->bloco_cadeira_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET (numero_cadeira = :numero_cadeira, nome_cadeira = :nome_cadeira, bloco_cadeira_id = :bloco_cadeira_id)
        WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':numero_cadeira',$this->numero_cadeira, PDO::PARAM_INT);
        $stmt->bindParam(':nome_cadeira',$this->nome_cadeira, PDO::PARAM_STR);
        $stmt->bindParam(':bloco_cadeira_id',$this->bloco_cadeira_id, PDO::PARAM_INT);
        $stmt->bindParam(':id',$this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function selectByBloco($bloco_cadeira_id){
        $sql = "SELECT * FROM $this->table WHERE bloco_cadeira_id = :bloco_cadeira_id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':bloco_cadeira_id',$bloco_cadeira_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNumeroCadeira()
    {
        return $this->numero_cadeira;
    }

    /**
     * @param mixed $numero_cadeira
     */
    public function setNumeroCadeira($numero_cadeira)
    {
        $this->numero_cadeira = $numero_cadeira;
    }

    /**
     * @return mixed
     */
    public function getNomeCadeira()
    {
        return $this->nome_cadeira;
    }

    /**
     * @param mixed $nome_cadeira
     */
    public function setNomeCadeira($nome_cadeira)
    {
        $this->nome_cadeira = $nome_cadeira;
    }

    /**
     * @return mixed
     */
    public function getBlocoCadeiraId()
    {
        return $this->bloco_cadeira_id;
    }

    /**
     * @param mixed $bloco_cadeira_id
     */
    public function setBlocoCadeiraId($bloco_cadeira_id)
    {
        $this->bloco_cadeira_id = $bloco_cadeira_id;
    }




}

