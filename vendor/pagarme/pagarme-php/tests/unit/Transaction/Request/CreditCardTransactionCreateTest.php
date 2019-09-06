<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\CreditCardTransactionCreate;
use PagarMe\Sdk\Transaction\CreditCardTransaction;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\RequestInterface;

class CreditCardTransactionCreateTest extends \PHPUnit_Framework_TestCase
{
    use FakeReferenceKey;

    const PATH   = 'transactions';

    const CARD_ID   = 1;
    const CARD_HASH = 'FC1mH7XLFU5fjPAzDsP0ogeAQh3qXRpHzkIrgDz64lITBUGwio67zm';

    public function referenceKeyProvider()
    {
        return [
            [1, true, null, null],
            [1, true, null, $this->getFakeReferenceKey()],
        ];
    }

    public function installmentsProvider()
    {
        return [
            [1,true,null, null],
            [3,true, 'example.com', 'Sua Loja', true],
            [12,false, 'example.com', null, false],
            [rand(1, 12), false, null, 'Outra Loja']
        ];
    }

    /**
     * @dataProvider installmentsProvider
     * @test
     */
    public function mustPayloadBeCorrect(
        $installments,
        $capture,
        $postbackUrl,
        $softDescriptor,
        $async = null
    ) {
        $transaction =  $this->getTransaction(
            $installments,
            $capture,
            $postbackUrl,
            $softDescriptor,
            $async
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_id'        => self::CARD_ID,
                'installments'   => $installments,
                'payment_method' => 'credit_card',
                'capture'        => $capture,
                'postback_url'   => $postbackUrl,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'metadata'        => null,
                'soft_descriptor' => $softDescriptor,
                'async'           => $async,
                'reference_key'   => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @dataProvider installmentsProvider
     * @test
     */
    public function mustNotContainAdressAndPhoneDataOnPayload(
        $installments,
        $capture,
        $postbackUrl
    ) {
        $customerMock = $this->getBlankCustomerMock();
        $cardMock     = $this->getCardMock();

        $transaction =  new CreditCardTransaction(
            [
                'amount'       => 1337,
                'card'         => $cardMock,
                'customer'     => $customerMock,
                'installments' => $installments,
                'capture'      => $capture,
                'postbackUrl'  => $postbackUrl,
                'reference_key' => null
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_id'        => self::CARD_ID,
                'installments'   => $installments,
                'payment_method' => 'credit_card',
                'capture'        => $capture,
                'postback_url'   => $postbackUrl,
                'customer' => [
                    'name'            => null,
                    'born_at'         => null,
                    'document_number' => null,
                    'email'           => null,
                    'sex'             => null
                ],
                'metadata'        => null,
                'soft_descriptor' => null,
                'async'           => null,
                'reference_key'   => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @dataProvider referenceKeyProvider
     * @test
     */
    public function mustContainsTheRightReferenceKey(
        $installments,
        $capture,
        $postbackUrl,
        $referenceKey
    ) {
        $customerMock = $this->getBlankCustomerMock();
        $cardMock     = $this->getCardMock();

        $transaction =  new CreditCardTransaction(
            [
                'amount'       => 1337,
                'card'         => $cardMock,
                'customer'     => $customerMock,
                'installments' => $installments,
                'capture'      => $capture,
                'postback_url'  => $postbackUrl,
                'reference_key' => $referenceKey
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_id'        => self::CARD_ID,
                'installments'   => $installments,
                'payment_method' => 'credit_card',
                'capture'        => $capture,
                'postback_url'   => $postbackUrl,
                'customer' => [
                    'name'            => null,
                    'born_at'         => null,
                    'document_number' => null,
                    'email'           => null,
                    'sex'             => null
                ],
                'metadata'        => null,
                'soft_descriptor' => null,
                'async'           => null,
                'reference_key'   => $referenceKey
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPayloadContainCustomerId()
    {
        $cardMock   = $this->getCardMock();

        $customer = $this->getBlankCustomerMock();
        $customer->method('getId')->willReturn(12345);

        $transaction =  new CreditCardTransaction(
            [
                'amount'       => 1337,
                'card'         => $cardMock,
                'customer'     => $customer,
                'installments' => 1,
                'capture'      => false,
                'postback_url' => null,
                'reference_key' => null
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_id'        => self::CARD_ID,
                'installments'   => 1,
                'payment_method' => 'credit_card',
                'capture'        => false,
                'postback_url'   => null,
                'customer' => [
                    'id'              => 12345,
                    'name'            => null,
                    'born_at'         => null,
                    'document_number' => null,
                    'email'           => null,
                    'sex'             => null
                ],
                'metadata'        => null,
                'soft_descriptor' => null,
                'async'           => null,
                'reference_key'   => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPayloadContainMonetarySplitRules()
    {
        $customerMock = $this->getFullCustomerMock();
        $cardMock     = $this->getCardMock();

        $rules = new SplitRuleCollection();
        $rules[]= new SplitRule([
            'amount'                => 100,
            'recipient'             => new Recipient(['id' => 1]),
            'liable'                => true,
            'charge_processing_fee' => true
        ]);
        $rules[]= new SplitRule([
            'amount'                => 1237,
            'recipient'             => new Recipient(['id' => 3]),
            'liable'                => false,
            'charge_processing_fee' => false
        ]);

        $transaction =  new CreditCardTransaction(
            [
                'amount'       => 1337,
                'card'         => $cardMock,
                'customer'     => $customerMock,
                'installments' => 1,
                'capture'      => false,
                'postback_url' => null,
                'split_rules'  => $rules,
                'reference_key' => null
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_id'        => self::CARD_ID,
                'installments'   => 1,
                'payment_method' => 'credit_card',
                'capture'        => false,
                'postback_url'   => null,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'split_rules' => [
                    0 => [
                        'amount'                => 100,
                        'recipient_id'          => 1,
                        'liable'                => true,
                        'charge_processing_fee' => true
                    ],
                    1 => [
                        'amount'                => 1237,
                        'recipient_id'          => 3,
                        'liable'                => false,
                        'charge_processing_fee' => false
                    ]
                ],
                'metadata'        => null,
                'soft_descriptor' => null,
                'async'           => null,
                'reference_key'   => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPayloadContainPercentageSplitRules()
    {
        $customerMock = $this->getFullCustomerMock();
        $cardMock     = $this->getCardMock();

        $rules = new SplitRuleCollection();
        $rules[]= new SplitRule([
            'percentage'            => 90,
            'recipient'             => new Recipient(['id' => 1]),
            'liable'                => true,
            'charge_processing_fee' => true
        ]);
        $rules[]= new SplitRule([
            'percentage'            => 10,
            'recipient'             => new Recipient(['id' => 3]),
            'liable'                => false,
            'charge_processing_fee' => false
        ]);

        $transaction =  new CreditCardTransaction(
            [
                'amount'        => 1337,
                'card'          => $cardMock,
                'customer'      => $customerMock,
                'installments'  => 1,
                'capture'       => false,
                'postback_url'  => null,
                'split_rules'   => $rules,
                'reference_key' => null
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_id'        => self::CARD_ID,
                'installments'   => 1,
                'payment_method' => 'credit_card',
                'capture'        => false,
                'postback_url'   => null,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'split_rules' => [
                    0 => [
                        'percentage'            => 90,
                        'recipient_id'          => 1,
                        'liable'                => true,
                        'charge_processing_fee' => true
                    ],
                    1 => [
                        'percentage'            => 10,
                        'recipient_id'          => 3,
                        'liable'                => false,
                        'charge_processing_fee' => false
                    ]
                ],
                'metadata'        => null,
                'soft_descriptor' => null,
                'async'           => null,
                'reference_key'   => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPayloadContainCardCvv()
    {
        $customerMock = $this->getFullCustomerMock();
        $cardMock     = $this->getCardMock();

        $transaction =  new CreditCardTransaction(
            [
                'amount'       => 1337,
                'card'         => $cardMock,
                'customer'     => $customerMock,
                'installments' => 1,
                'capture'      => false,
                'postback_url' => null,
                'card_cvv'     => 123
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $payload = $transactionCreate->getPayload();

        $this->assertArrayHasKey('card_cvv', $payload);
        $this->assertEquals(123, $payload['card_cvv']);
    }

    /**
     * @dataProvider installmentsProvider
     * @test
     */
    public function mustPayloadContainCardHash($installments, $capture, $postbackUrl)
    {
        $customerMock = $this->getFullCustomerMock();
        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();

        $cardMock->method('getHash')
            ->willReturn(self::CARD_HASH);

        $transaction =  new CreditCardTransaction(
            [
                'amount'       => 1337,
                'card'         => $cardMock,
                'customer'     => $customerMock,
                'installments' => $installments,
                'capture'      => $capture,
                'postback_url'  => $postbackUrl,
                'reference_key' => null
            ]
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'         => 1337,
                'card_hash'      => self::CARD_HASH,
                'installments'   => $installments,
                'payment_method' => 'credit_card',
                'capture'        => $capture,
                'postback_url'   => $postbackUrl,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'metadata'        => null,
                'soft_descriptor' => null,
                'async'           => null,
                'reference_key'   => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $transaction =  $this->getTransaction(
            rand(1, 12),
            false,
            null,
            null,
            null
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(self::PATH, $transactionCreate->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $transaction =  $this->getTransaction(
            rand(1, 12),
            false,
            null,
            null,
            null
        );

        $transactionCreate = new CreditCardTransactionCreate($transaction);

        $this->assertEquals(RequestInterface::HTTP_POST, $transactionCreate->getMethod());
    }

    private function getTransaction(
        $installments,
        $capture,
        $postbackUrl,
        $softDescriptor,
        $async
    ) {
        $customerMock = $this->getFullCustomerMock();
        $cardMock     = $this->getCardMock();

        $transaction =  new CreditCardTransaction(
            [
                'amount'         => 1337,
                'card'           => $cardMock,
                'customer'       => $customerMock,
                'installments'   => $installments,
                'capture'        => $capture,
                'postback_url'    => $postbackUrl,
                'soft_descriptor' => $softDescriptor,
                'async'          => $async,
            ]
        );

        return $transaction;
    }

    public function getCardMock()
    {
        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();

        $cardMock->method('getId')
            ->willReturn(self::CARD_ID);

        return $cardMock;
    }


    public function getFullCustomerMock()
    {
        $customerMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $customerMock->method('getBornAt')->willReturn('15071991');
        $customerMock->method('getDocumentNumber')->willReturn('10586649727');
        $customerMock->method('getEmail')->willReturn('eduardo@eduardo.com');
        $customerMock->method('getGender')->willReturn('M');
        $customerMock->method('getName')->willReturn('Eduardo Nascimento');
        $customerMock->method('getAddress')->willReturn(
            [
                'street'        => 'rua teste',
                'street_number' => 42,
                'neighborhood'  => 'centro',
                'zipcode'       => '01227200'
            ]
        );
        $customerMock->method('getPhone')->willReturn(
            [
                'ddi'    => 55,
                'ddd'    => 15,
                'number' => 987523421
            ]
        );

        return $customerMock;
    }

    public function getBlankCustomerMock()
    {
        $customerMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $customerMock->method('getBornAt')->willReturn(null);
        $customerMock->method('getDocumentNumber')->willReturn(null);
        $customerMock->method('getEmail')->willReturn(null);
        $customerMock->method('getGender')->willReturn(null);
        $customerMock->method('getName')->willReturn(null);
        $customerMock->method('getAddress')->willReturn(null);
        $customerMock->method('getPhone')->willReturn(null);

        return $customerMock;
    }
}
