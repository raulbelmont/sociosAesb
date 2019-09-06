<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Customer\Customer;

class SplitRuleContext extends BasicContext
{
    use Helper\CustomerDataProvider;
    use Helper\RecipientData;

    private $customer;
    private $splitRules;
    private $creditCard;
    /** @var \PagarMe\Sdk\Transaction\AbstractTransaction */
    private $transaction;

    /**
     * @Given a valid customer
     */
    public function aValidCustomer()
    {
        $customerData = $this->getValidCustomerData();
        $this->customer = new Customer($customerData);
    }

    /**
     * @Given valid splitRule
     */
    public function validSplitrule()
    {
        $this->splitRules = new SplitRuleCollection();
        $this->splitRules[]= self::getPagarMe()
            ->splitRule()
            ->percentageRule(51, $this->createRecipient(), null, null, true);
        $this->splitRules[]=self::getPagarMe()
            ->splitRule()
            ->percentageRule(49, $this->createRecipient(), null, null, false);
    }

    /**
     * @Given a valid card
     */
    public function aValidCard()
    {
        $this->creditCard = self::getPagarMe()
            ->card()
            ->create('4539706041746367', "John Doe", '0725');
    }

    /**
     * @When make a credit card transaction
     */
    public function makeACreditCardTransaction()
    {
        $this->transaction = self::getPagarMe()
            ->transaction()
            ->creditCardTransaction(
                5000,
                $this->creditCard,
                $this->customer,
                1,
                true,
                null,
                null,
                ['split_rules' => $this->splitRules]
            );
    }

    /**
     * @When make a boleto transaction
     */
    public function makeABoletoTransaction()
    {
        $this->transaction = self::getPagarMe()
            ->transaction()
            ->boletoTransaction(
                5000,
                $this->customer,
                null,
                null,
                ['split_rules' => $this->splitRules]
            );
    }


    /**
     * @Then a transaction must be created
     */
    public function aTransactionMustBeCreated()
    {
        assertInstanceOf(
            'PagarMe\Sdk\Transaction\AbstractTransaction',
            $this->transaction
        );
    }

    /**
     * @Then the transaction must contain split rule
     */
    public function theTransactionMustContainSplitRule()
    {
        assertInstanceOf(
            'PagarMe\Sdk\SplitRule\SplitRuleCollection',
            $this->transaction->getSplitRules()
        );
    }

    /**
     * @Then the split rule must be countable
     */
    public function theSplitRuleMustBeCountable()
    {
        assertInstanceOf(
            'Countable',
            $this->transaction->getSplitRules()
        );
    }

    /**
     * @Then the split rules count must be :quantity
     */
    public function theSplitRulesCountMustBe($quantity)
    {
        $countedSplitRules = count($this->transaction->getSplitRules());
        assertInternalType('int', $countedSplitRules);
        assertEquals($quantity, $countedSplitRules);
    }
}
