<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 26/01/2019
 * Time: 20:56
 */

require_once 'CRUD.php';
class Administrador extends CRUD
{
    private $id; //bigint
    private $nome_completo; //varchar
    private $email; //varchar
    private $cpf; //varchar

    protected $table = "administrador";


    public function insert()
    {
        $sql = "INSERT INTO $this->table (nome_completo, email, cpf) VALUES (:nome_completo, :email, :cpf) ";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':nome_completo', $this->nome_completo, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET nome_completo = :nome_completo, email = :email, cpf = :cpf WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':nome_completo', $this->nome_completo, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();

    }

    /*buscar por CPF*/
    public function selectCPF($cpf){
        $sql = "SELECT * FROM $this->table WHERE cpf = :cpf";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':cpf', $cpf , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /*Recuperar senha*/
    public function recuperarSenha($cpf,$email){
        $sql = "SELECT * FROM $this->table WHERE cpf = :cpf and email = :email";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':cpf', $cpf , PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
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
    public function getNomeCompleto()
    {
        return $this->nome_completo;
    }

    /**
     * @param mixed $nome_completo
     */
    public function setNomeCompleto($nome_completo)
    {
        $this->nome_completo = $nome_completo;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }




}

