<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use PagarMe\Sdk\Customer\Customer;

class CustomerContext extends BasicContext
{
    use Helper\CustomerDataProvider;

    private $customer;
    private $customerData;
    private $customerList;

    /**
     * @Given customer data
     */
    public function customerData()
    {
        $this->customerData = $this->getValidCustomerData();
    }

    /**
     * @When register this data
     */
    public function registerThisData()
    {
        $address = new \PagarMe\Sdk\Customer\Address(
            [
                'street' => 'rua teste',
                'street_number' => 42,
                'neighborhood' => 'centro',
                'zipcode' => '01227200'
            ]
        );

        $this->customer = self::getPagarMe()
            ->customer()
            ->create(
                $this->getCustomerName(),
                $this->getCustomerEmail(),
                $this->getCustomerDocumentNumber(),
                $address,
                new \PagarMe\Sdk\Customer\Phone(
                    [
                        'ddd' =>11,
                        'number' =>987654321
                    ]
                )
            );
    }

    /**
     * @Then an customer must be created
     */
    public function anCustomerMustBeCreated()
    {
        assertInstanceOf('PagarMe\Sdk\Customer\Customer', $this->customer);
    }

    /**
     * @Then the customer must be retrievable
     */
    public function theCustomerMustBeRetrievable()
    {
        $customer = self::getPagarMe()
            ->customer()
            ->get($this->customer->getId());

        assertEquals($customer, $this->customer);
    }
}
