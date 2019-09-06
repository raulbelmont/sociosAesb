<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 26/01/2019
 * Time: 16:32
 */
require_once 'CRUD.php';
class Bloco_cadeira extends CRUD
{
    private $id; //bigint
    private $nome; //varchar

    protected $table = "bloco_cadeira";

    public function insert()
    {
        $sql = "INSERT INTO $this->table (nome) VALUES (:nome)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':nome',$this->nome, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET nome = :nome WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':nome',$this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':id',$this->id, PDO::PARAM_INT);
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }




}


