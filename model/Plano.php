<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:21
 */
require_once 'CRUD.php';
class Plano extends CRUD
{

    private $id; //bigint
    private $amount; //int
    private $days; //int
    private $name; //varchar
    private $payment_methods; //varchar
    private $color; //varchar
    private $charges; //int
    private $installments; //int
    private $invoice_reminder; //int
    private $date_created; //datetime
    private $valor_adesao; //float
    private $visibilidade; //boolean
    private $mensalidade; //float
    private $publico; //varchar
    private $isCadeira; //boolean
    private $id_pagarme; //bigint

    protected $table = "plano";


    public function insert()
    {
        $sql = "INSERT INTO $this->table (amount, days, name_plan, payment_methods, color, charges, installments, invoice_reminder, date_created
        , valor_adesao, visibilidade, mensalidade, publico, isCadeira, id_pagarme) VALUES  (:amount, :days, :name_plan, :payment_methods, :color, :charges, :installments,
         :invoice_reminder, :date_created, :valor_adesao, :visibilidade, :mensalidade, :publico, :isCadeira, :id_pagarme)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':amount',$this->amount,PDO::PARAM_INT);
        $stmt->bindParam('days',$this->days,PDO::PARAM_INT);
        $stmt->bindParam(':name_plan',$this->name,PDO::PARAM_STR);
        $stmt->bindParam(':payment_methods',$this->payment_methods,PDO::PARAM_STR);
        $stmt->bindParam(':color',$this->color,PDO::PARAM_STR);
        $stmt->bindParam(':charges',$this->charges,PDO::PARAM_INT);
        $stmt->bindParam(':installments',$this->installments,PDO::PARAM_INT);
        $stmt->bindParam(':invoice_reminder',$this->invoice_reminder,PDO::PARAM_INT);
        $stmt->bindParam(':date_created',$this->date_created, PDO::PARAM_STR);
        $stmt->bindParam(':valor_adesao',$this->valor_adesao, PDO::PARAM_STR);
        $stmt->bindParam(':visibilidade',$this->visibilidade,PDO::PARAM_BOOL);
        $stmt->bindParam(':mensalidade',$this->mensalidade,PDO::PARAM_STR);
        $stmt->bindParam(':publico',$this->publico,PDO::PARAM_STR);
        $stmt->bindParam(':isCadeira',$this->isCadeira,PDO::PARAM_STR);
        $stmt->bindParam(':id_pagarme',$this->id_pagarme,PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET amount = :amount , days = :days, name_plan = :name_plan, payment_methods = :payment_methods, color = :color,
        charges = :charges, installments = :installments, invoice_reminder = :invoice_reminder, date_created = :date_created, valor_adesao = :valor_adesao,
        visibilidade = :visibilidade, mensalidade = :mensalidade, publico = :publico, isCadeira = :isCadeira, id_pagarme = :id_pagarme WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':amount',$this->amount,PDO::PARAM_INT);
        $stmt->bindParam('days',$this->days,PDO::PARAM_INT);
        $stmt->bindParam(':name_plan',$this->name,PDO::PARAM_STR);
        $stmt->bindParam(':payment_methods',$this->payment_methods,PDO::PARAM_STR);
        $stmt->bindParam(':color',$this->color,PDO::PARAM_STR);
        $stmt->bindParam(':charges',$this->charges,PDO::PARAM_INT);
        $stmt->bindParam(':installments',$this->installments,PDO::PARAM_INT);
        $stmt->bindParam(':invoice_reminder',$this->invoice_reminder,PDO::PARAM_INT);
        $stmt->bindParam(':date_created',$this->date_created, PDO::PARAM_STR);
        $stmt->bindParam(':valor_adesao',$this->valor_adesao, PDO::PARAM_STR);
        $stmt->bindParam(':visibilidade',$this->visibilidade,PDO::PARAM_BOOL);
        $stmt->bindParam(':mensalidade',$this->mensalidade,PDO::PARAM_STR);
        $stmt->bindParam(':publico',$this->publico,PDO::PARAM_STR);
        $stmt->bindParam(':isCadeira',$this->isCadeira,PDO::PARAM_STR);
        $stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $stmt->bindParam(':id_pagarme',$this->id_pagarme,PDO::PARAM_INT);
        return $stmt->execute();

    }

    public function selectByIDPGM($id_pagarme){
        $sql = "SELECT * FROM $this->table WHERE id_pagarme = :id_pagarme";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':id_pagarme',$id_pagarme,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function selectAllPublic($visibilidade){
        $sql = "SELECT * FROM $this->table WHERE visibilidade = :visibilidade";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':visibilidade',$visibilidade);
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
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethods()
    {
        return $this->payment_methods;
    }

    /**
     * @param mixed $payment_methods
     */
    public function setPaymentMethods($payment_methods)
    {
        $this->payment_methods = $payment_methods;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param mixed $charges
     */
    public function setCharges($charges)
    {
        $this->charges = $charges;
    }

    /**
     * @return mixed
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @param mixed $installments
     */
    public function setInstallments($installments)
    {
        $this->installments = $installments;
    }

    /**
     * @return mixed
     */
    public function getInvoiceReminder()
    {
        return $this->invoice_reminder;
    }

    /**
     * @param mixed $invoice_reminder
     */
    public function setInvoiceReminder($invoice_reminder)
    {
        $this->invoice_reminder = $invoice_reminder;
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
    public function getValorAdesao()
    {
        return $this->valor_adesao;
    }

    /**
     * @param mixed $valor_adesao
     */
    public function setValorAdesao($valor_adesao)
    {
        $this->valor_adesao = $valor_adesao;
    }

    /**
     * @return mixed
     */
    public function getVisibilidade()
    {
        return $this->visibilidade;
    }

    /**
     * @param mixed $visibilidade
     */
    public function setVisibilidade($visibilidade)
    {
        $this->visibilidade = $visibilidade;
    }

    /**
     * @return mixed
     */
    public function getMensalidade()
    {
        return $this->mensalidade;
    }

    /**
     * @param mixed $mensalidade
     */
    public function setMensalidade($mensalidade)
    {
        $this->mensalidade = $mensalidade;
    }

    /**
     * @return mixed
     */
    public function getPublico()
    {
        return $this->publico;
    }

    /**
     * @param mixed $publico
     */
    public function setPublico($publico)
    {
        $this->publico = $publico;
    }

    /**
     * @return mixed
     */
    public function getisCadeira()
    {
        return $this->isCadeira;
    }

    /**
     * @param mixed $isCadeira
     */
    public function setIsCadeira($isCadeira)
    {
        $this->isCadeira = $isCadeira;
    }

    /**
     * @return mixed
     */
    public function getIdPagarme()
    {
        return $this->id_pagarme;
    }

    /**
     * @param mixed $id_pagarme
     */
    public function setIdPagarme($id_pagarme)
    {
        $this->id_pagarme = $id_pagarme;
    }








}