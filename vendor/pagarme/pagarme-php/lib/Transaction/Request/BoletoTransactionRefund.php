<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Transaction\BoletoTransaction;
use PagarMe\Sdk\BankAccount\BankAccount;

class BoletoTransactionRefund implements RequestInterface
{
    /**
     * @var BoletoTransaction
     */
    protected $transaction;
    /**
     * @var BankAccount
     */
    protected $bankAccount;
    /**
     * @var int
     */
    protected $amount;

    /**
     * @param BoletoTransaction $transaction
     * @param BankAccount $bankAccount
     * @param int $amount
     */
    public function __construct(
        BoletoTransaction $transaction,
        BankAccount $bankAccount,
        $amount = null
    ) {
        $this->transaction = $transaction;
        $this->bankAccount = $bankAccount;
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->getBankAccountData();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf('transactions/%d/refund', $this->transaction->getId());
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }

    /**
     * @return array
     */
    private function getBankAccountData()
    {
        $bankAccount = $this->bankAccount;

        if (is_null($bankAccount->getId())) {
            return [
                'bank_account' => [
                    'bank_code'       => $bankAccount->getBankCode(),
                    'agencia'         => $bankAccount->getAgencia(),
                    'agencia_dv'      => $bankAccount->getAgenciaDv(),
                    'conta'           => $bankAccount->getConta(),
                    'conta_dv'        => $bankAccount->getContaDv(),
                    'document_number' => $bankAccount->getDocumentNumber(),
                    'legal_name'      => $bankAccount->getLegalName()
                ]
            ];
        }

        return ['bank_account_id' => $bankAccount->getId()];
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
