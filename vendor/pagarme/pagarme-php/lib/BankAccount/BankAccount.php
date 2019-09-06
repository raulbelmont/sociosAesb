<?php

namespace PagarMe\Sdk\BankAccount;

class BankAccount
{
    use \PagarMe\Sdk\Fillable;

    const TYPE_CONTA_CORRENTE          = 'conta_corrente';
    const TYPE_CONTA_POUPANCA          = 'conta_poupanca';
    const TYPE_CONTA_CORRENTE_CONJUNTA = 'conta_corrente_conjunta';
    const TYPE_CONTA_POUPANCA_CONJUNTA = 'conta_poupanca_conjunta';

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $bankCode;

    /**
     * @var int
     */
    private $agencia;

    /**
     * @var int
     */
    private $agenciaDv;

    /**
     * @var int
     */
    private $conta;

    /**
     * @var int
     */
    private $contaDv;

    /**
     * @var int
     */
    private $documentNumber;

    /**
     * @var string
     */
    private $documentType;

    /**
     * @var string
     */
    private $legalName;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var string
     */
    private $type;

    /**
     * @param array $arrayData
     */
    public function __construct($arrayData)
    {
        $this->fill($arrayData);
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    /**
     * @return \DateTime
     * @codeCoverageIgnore
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @returnstring \DateTime
     * @codeCoverageIgnore
     */
    public function getType()
    {
        return $this->type;
    }
}
