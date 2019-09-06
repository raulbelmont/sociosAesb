<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:20
 */
require_once 'CRUD.php';
class Senha extends CRUD
{
    private $id; //bigint
    private $senha; //varchar
    private $usuario_id; //bigint
    private $administrador_id; //bigint

    protected $table = 'senha';

    public function insert()
    {
        $sql = "INSERT INTO $this->table (id, senha, usuario_id, administrador_id) VALUES (:id,:senha, :usuario_id, :administrador_id)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':id',$this->id, PDO::PARAM_INT);
        $stmt->bindParam(':senha',$this->senha, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id',$this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':administrador_id',$this->administrador_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET senha = :senha WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':id',$this->id, PDO::PARAM_INT);
        $stmt->bindParam(':senha',$this->senha, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /*buscando senha*/
    public function selectSenha($param , $valor){
        $sql = "SELECT * FROM $this->table WHERE $param  = :valor";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':valor',$valor,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
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
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * @param mixed $usuario_id
     */
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    /**
     * @return mixed
     */
    public function getAdministradorId()
    {
        return $this->administrador_id;
    }

    /**
     * @param mixed $administrador_id
     */
    public function setAdministradorId($administrador_id)
    {
        $this->administrador_id = $administrador_id;
    }





}