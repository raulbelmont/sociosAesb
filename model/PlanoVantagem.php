<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:20
 */
require_once 'CRUD.php';
class PlanoVantagem extends CRUD
{
    private $id; //bigint
    private $vantagem; //varchar
    private $plano_id; //bigint

    protected $table = 'plano_vantagem';

    public function insert()
    {
        $sql = "INSERT INTO $this->table (vantagem, plano_id) VALUES (:vantagem, :plano_id)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':vantagem',$this->vantagem, PDO::PARAM_STR);
        $stmt->bindParam(':plano_id', $this->plano_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET vantagem = :vantagem, plano_id = :plano_id WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':vantagem',$this->vantagem, PDO::PARAM_STR);
        $stmt->bindParam(':plano_id', $this->plano_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /*Selecionar por plano*/
    public function selectByPlano($plano_id){
        $sql = "SELECT * FROM $this->table WHERE plano_id = :plano_id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':plano_id',$plano_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteByPlano($plano_id){
        $sql = "DELETE FROM $this->table WHERE plano_id =:plano_id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':plano_id',$plano_id,PDO::PARAM_INT);
        return $stmt->execute();
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
    public function getVantagem()
    {
        return $this->vantagem;
    }

    /**
     * @param mixed $vantagem
     */
    public function setVantagem($vantagem)
    {
        $this->vantagem = $vantagem;
    }

    /**
     * @return mixed
     */
    public function getPlanoId()
    {
        return $this->plano_id;
    }

    /**
     * @param mixed $plano_id
     */
    public function setPlanoId($plano_id)
    {
        $this->plano_id = $plano_id;
    }



}