<?php

namespace PagarMe\Sdk\Transaction;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Client;
use PagarMe\Sdk\Payable\PayableBuilder;
use PagarMe\Sdk\Transaction\Request\CreditCardTransactionCreate;
use PagarMe\Sdk\Transaction\Request\BoletoTransactionCreate;
use PagarMe\Sdk\Transaction\Request\TransactionGet;
use PagarMe\Sdk\Transaction\Request\TransactionList;
use PagarMe\Sdk\Transaction\Request\TransactionCapture;
use PagarMe\Sdk\Transaction\Request\TransactionEvents;
use PagarMe\Sdk\Transaction\Request\TransactionPayables;
use PagarMe\Sdk\Transaction\Request\CreditCardTransactionRefund;
use PagarMe\Sdk\Transaction\Request\BoletoTransactionRefund;
use PagarMe\Sdk\Transaction\Request\TransactionPay;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;

class TransactionHandler extends AbstractHandler
{
    use PayableBuilder;
    use TransactionBuilder;
    use \PagarMe\Sdk\Event\EventBuilder;

    /**
     * @param int $amount
     * @param \PagarMe\Sdk\Card\Card $card
     * @param \PagarMe\Sdk\Customer\Customer $customer
     * @param int $installments
     * @param boolean $capture
     * @param string $postBackUrl
     * @param array $metadata
     * @param array $extraAttributes
     * @return CreditCardTransaction
     */
    public function creditCardTransaction(
        $amount,
        Card $card,
        Customer $customer,
        $installments = 1,
        $capture = true,
        $postBackUrl = null,
        $metadata = null,
        $extraAttributes = []
    ) {
        $transactionData = array_merge(
            [
                'amount'       => $amount,
                'card'         => $card,
                'customer'     => $customer,
                'installments' => $installments,
                'capture'      => $capture,
                'postbackUrl'  => $postBackUrl,
                'metadata'     => $metadata
            ],
            $extraAttributes
        );

        $transaction = new CreditCardTransaction($transactionData);
        $request = new CreditCardTransactionCreate($transaction);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param int $amount
     * @param \PagarMe\Sdk\Customer\Customer $customer
     * @param string $postBackUrl
     * @param mixed $metadata
     * @param array $extraAttributes
     * @return BoletoTransaction
     */
    public function boletoTransaction(
        $amount,
        Customer $customer,
        $postBackUrl,
        $metadata = null,
        $extraAttributes = []
    ) {
        $transactionData = array_merge(
            [
                'amount'      => $amount,
                'customer'    => $customer,
                'postbackUrl' => $postBackUrl,
                'metadata'    => $metadata
            ],
            $extraAttributes
        );

        $transaction = new BoletoTransaction($transactionData);

        $request = new BoletoTransactionCreate($transaction);

        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param int $transactionId
     * @return BoletoTransaction | CreditCardTransaction
     */
    public function get($transactionId)
    {
        $request = new TransactionGet($transactionId);

        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param $transactionId
     * @return array
     * @throws \PagarMe\Sdk\ClientException
     */
    public function payables($transactionId)
    {
        $request = new TransactionPayables($transactionId);

        $response = $this->client->send($request);

        $payables = [];

        foreach ($response as $payableData) {
            $payables[] = $this->buildPayable($payableData);
        }

        return $payables;
    }

    /**
     * @param int $page
     * @param int $count
     * @return array
     */
    public function getList($page = null, $count = null)
    {
        $request = new TransactionList($page, $count);
        $response = $this->client->send($request);

        $transactions = [];
        foreach ($response as $transactionData) {
            $transactions[] = $this->buildTransaction($transactionData);
        }

        return $transactions;
    }

    /**
     * @param AbstractTransaction $transaction
     * @param int $amount
     * @param array $metadata
     * @param \PagarMe\Sdk\SplitRule\SplitRuleCollection $splitRules
     * @return AbstractTransaction
     */
    public function capture(
        AbstractTransaction $transaction,
        $amount = null,
        $metadata = [],
        SplitRuleCollection $splitRules = null
    ) {
        $request = new TransactionCapture($transaction, $amount, $metadata, $splitRules);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param CreditCardTransaction $transaction
     * @param int $amount
     * @return CreditCardTransaction
     */
    public function creditCardRefund(CreditCardTransaction $transaction, $amount = null)
    {
        $request = new CreditCardTransactionRefund($transaction, $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param BoletoTransaction $transaction
     * @param \PagarMe\Sdk\BankAccount\BankAccount $bankAccount
     * @param int @amount
     * @return BoletoTransaction
     */
    public function boletoRefund(
        BoletoTransaction $transaction,
        BankAccount $bankAccount,
        $amount = null
    ) {
        $request = new BoletoTransactionRefund(
            $transaction,
            $bankAccount,
            $amount
        );

        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param BoletoTransaction $transaction
     * @return BoletoTransaction
     */
    public function payTransaction(BoletoTransaction $transaction)
    {
        $request = new TransactionPay($transaction);

        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param AbstractTransaction $transaction
     * @return array
     */
    public function events(AbstractTransaction $transaction)
    {
        $request = new TransactionEvents($transaction);

        $response = $this->client->send($request);

        $events = [];

        foreach ($response as $eventData) {
            $events[] = $this->buildEvent($eventData);
        }

        return $events;
    }
}
