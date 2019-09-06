<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:22
 */
require_once 'CRUD.php';
class Assinatura extends CRUD
{
    private $id; //bigint
    private $payment_method; //varchar
    private $date_created; //datetime
    private $status; //varchar
    private $matricula_socio; //bigInt
    private $cadeira_id; //bigint
    private $usuario_id; //bigInt
    private $plano_id; //bigInt

    protected $table = 'assinatura';

    public function insert()
    {
        $sql = "INSERT INTO $this->table (payment_method, date_created, status, matricula_socio, cadeira_id, usuario_id, plano_id)
        VALUES (:payment_method, :date_created, :status, :matricula_socio, :cadeira_id, :usuario_id, :plano_id)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':payment_method',$this->payment_method, PDO::PARAM_STR);
        $stmt->bindParam(':date_created',$this->date_created, PDO::PARAM_STR);
        $stmt->bindParam(':status',$this->status, PDO::PARAM_STR);
        $stmt->bindParam(':matricula_socio',$this->matricula_socio, PDO::PARAM_INT);
        $stmt->bindParam(':cadeira_id',$this->cadeira_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id',$this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':plano_id',$this->plano_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET payment_method = :payment_method, date_created = :date_created, status = :status, 
        matricula_socio = :matricula_socio, cadeira_id = :cadeira_id, usuario_id = :usuario_id, plano_id = :plano_id WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':payment_method',$this->payment_method, PDO::PARAM_STR);
        $stmt->bindParam(':date_created',$this->date_created, PDO::PARAM_STR);
        $stmt->bindParam(':status',$this->status, PDO::PARAM_STR);
        $stmt->bindParam(':matricula_socio',$this->matricula_socio, PDO::PARAM_INT);
        $stmt->bindParam(':cadeira_id',$this->cadeira_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id',$this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':plano_id',$this->plano_id, PDO::PARAM_INT);
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
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @param mixed $payment_method
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMatriculaSocio()
    {
        return $this->matricula_socio;
    }

    /**
     * @param mixed $matricula_socio
     */
    public function setMatriculaSocio($matricula_socio)
    {
        $this->matricula_socio = $matricula_socio;
    }

    /**
     * @return mixed
     */
    public function getCadeiraId()
    {
        return $this->cadeira_id;
    }

    /**
     * @param mixed $cadeira_id
     */
    public function setCadeiraId($cadeira_id)
    {
        $this->cadeira_id = $cadeira_id;
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