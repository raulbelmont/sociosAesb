Feature: Bank Account
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu possa manter contas bancarias

  Scenario Outline: Creating account
    Given following account data "<bank_code>", "<office>", "<acc_number>", "<acc_digit>", "<document>", "<name>", "<off_digit>" and "<type>"
    When register the bank account
    Then a account must be created
    And must account contain same data
    Examples:
    | bank_code | office    |  acc_number   | acc_digit | document    | name            | off_digit | type                      |
    | 001       | 1977      | 1935          | 1         | 67178880244 | Maria Silva     | 1         | null                      |
    | 033       | 1986      | 010203        | 2         | 75232346660 | Carlos Silva    | null      | conta_corrente            |
    | 104       | 1991      | 10001         | 3         | 13067245890 | Cesar Silva     | 3         | conta_poupanca            |
    | 237       | 2006      | 80486         | 4         | 26260865686 | Luiza Silva     | null      | conta_corrente_conjunta   |
    | 341       | 2007      | 233500        | 5         | 11663782687 | Joao Silva      | null      | conta_poupanca_conjunta   |

  Scenario: Get bank account
    Given a previous created bank account
    When I query for created bank account
    Then a bank account must be returned
    And must the same bank account
