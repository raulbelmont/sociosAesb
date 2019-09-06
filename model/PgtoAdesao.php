<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:21
 */

require_once 'CRUD.php';
class PgtoAdesao extends CRUD
{
    private $id; //bigint
    private $amount; //int
    private $payment_method; //varchar
    private $status; //varchar
    private $date_created; //datetime
    private $date_update; //datetime
    private $boleto_url; //varchar
    private $boleto_bar_code; //varchar
    private $boleto_expiration_date; //date
    private $plano_id;

    protected $table = 'pgto_adesao';

    public function insert()
    {
        $sql = "INSERT INTO $this->table (amount, payment_methods, status, date_created, date_update, boleto_url, boleto_bar_code, boleto_expiration_date, plano_id)
        VALUES (:amount, :payment_methods, :status, :date_created, :date_update, :boleto_url, :boleto_bar_code, :boleto_expiration_date, :plano_id)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':amount',$this->amount,PDO::PARAM_INT);
        $stmt->bindParam(':payment_methods',$this->payment_method,PDO::PARAM_STR);
        $stmt->bindParam(':status',$this->status,PDO::PARAM_STR);
        $stmt->bindParam(':date_created',$this->date_created,PDO::PARAM_STR);
        $stmt->bindParam(':date_update',$this->date_update,PDO::PARAM_STR);
        $stmt->bindParam(':boleto_url',$this->boleto_url,PDO::PARAM_STR);
        $stmt->bindParam(':boleto_bar_code',$this->boleto_bar_code,PDO::PARAM_STR);
        $stmt->bindParam(':boleto_expiration_date',$this->boleto_expiration_date,PDO::PARAM_STR);
        $stmt->bindParam(':plano_id',$this->plano_id,PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET amount = :amount, payment_methods = :payment_methods, status = :status, date_created = :date_created,
        date_update = :date_update, boleto_url = :boleto_url, boleto_bar_code = :boleto_bar_code, boleto_expiration_date = :boleto_expiration_date,
        plano_id = :plano_id WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':amount',$this->amount,PDO::PARAM_INT);
        $stmt->bindParam(':payment_methods',$this->payment_method,PDO::PARAM_STR);
        $stmt->bindParam(':status',$this->status,PDO::PARAM_STR);
        $stmt->bindParam(':date_created',$this->date_created,PDO::PARAM_STR);
        $stmt->bindParam(':date_update',$this->date_update,PDO::PARAM_STR);
        $stmt->bindParam(':boleto_url',$this->boleto_url,PDO::PARAM_STR);
        $stmt->bindParam(':boleto_bar_code',$this->boleto_bar_code,PDO::PARAM_STR);
        $stmt->bindParam(':boleto_expiration_date',$this->boleto_expiration_date,PDO::PARAM_STR);
        $stmt->bindParam(':plano_id',$this->plano_id,PDO::PARAM_INT);
        $stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
    public function getDateUpdate()
    {
        return $this->date_update;
    }

    /**
     * @param mixed $date_update
     */
    public function setDateUpdate($date_update)
    {
        $this->date_update = $date_update;
    }

    /**
     * @return mixed
     */
    public function getBoletoUrl()
    {
        return $this->boleto_url;
    }

    /**
     * @param mixed $boleto_url
     */
    public function setBoletoUrl($boleto_url)
    {
        $this->boleto_url = $boleto_url;
    }

    /**
     * @return mixed
     */
    public function getBoletoBarCode()
    {
        return $this->boleto_bar_code;
    }

    /**
     * @param mixed $boleto_bar_code
     */
    public function setBoletoBarCode($boleto_bar_code)
    {
        $this->boleto_bar_code = $boleto_bar_code;
    }

    /**
     * @return mixed
     */
    public function getBoletoExpirationDate()
    {
        return $this->boleto_expiration_date;
    }

    /**
     * @param mixed $boleto_expiration_date
     */
    public function setBoletoExpirationDate($boleto_expiration_date)
    {
        $this->boleto_expiration_date = $boleto_expiration_date;
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