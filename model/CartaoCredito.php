<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:22
 */

require_once 'CRUD.php';
class CartaoCredito extends CRUD
{
    private $id; //bigint
    private $card_id; //varchar
    private $card_hash; //varchar
    private $card_holder_name; //varchar
    private $card_expiration_date; //varchar
    private $card_number; //int
    private $card_brand; //int

    protected $table = "cartao_credito";


    public function insert()
    {
        $sql = "INSERT INTO $this->table (card_id, card_hash, card_holder_name, card_expiration_date,
        card_number, card_brand) VALUES (:card_id, :card_hash, :card_holder_name, :card_expiration_date,
        :card_number, :card_brand)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':card_id', $this->card_id, PDO::PARAM_INT);
        $stmt->bindParam(':card_hash', $this->card_hash, PDO::PARAM_STR);
        $stmt->bindParam(':card_holder_name', $this->card_holder_name, PDO::PARAM_STR);
        $stmt->bindParam(':card_expiration_date', $this->card_expiration_date, PDO::PARAM_STR);
        $stmt->bindParam(':card_number', $this->card_number, PDO::PARAM_INT);
        $stmt->bindParam(':card_brand', $this->card_brand, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET (card_id = :card_id, card_hash = :card_hash, card_holder_name = :card_holder_name,
        card_expiration_date = :card_expiration_date, card_number = :card_number, card_brand = :card_brand) WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':card_id', $this->card_id, PDO::PARAM_INT);
        $stmt->bindParam(':card_hash', $this->card_hash, PDO::PARAM_STR);
        $stmt->bindParam(':card_holder_name', $this->card_holder_name, PDO::PARAM_STR);
        $stmt->bindParam(':card_expiration_date', $this->card_expiration_date, PDO::PARAM_STR);
        $stmt->bindParam(':card_number', $this->card_number, PDO::PARAM_INT);
        $stmt->bindParam(':card_brand', $this->card_brand, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute;

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
    public function getCardId()
    {
        return $this->card_id;
    }

    /**
     * @param mixed $card_id
     */
    public function setCardId($card_id)
    {
        $this->card_id = $card_id;
    }

    /**
     * @return mixed
     */
    public function getCardHash()
    {
        return $this->card_hash;
    }

    /**
     * @param mixed $card_hash
     */
    public function setCardHash($card_hash)
    {
        $this->card_hash = $card_hash;
    }

    /**
     * @return mixed
     */
    public function getCardHolderName()
    {
        return $this->card_holder_name;
    }

    /**
     * @param mixed $card_holder_name
     */
    public function setCardHolderName($card_holder_name)
    {
        $this->card_holder_name = $card_holder_name;
    }

    /**
     * @return mixed
     */
    public function getCardExpirationDate()
    {
        return $this->card_expiration_date;
    }

    /**
     * @param mixed $card_expiration_date
     */
    public function setCardExpirationDate($card_expiration_date)
    {
        $this->card_expiration_date = $card_expiration_date;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getCardBrand()
    {
        return $this->card_brand;
    }

    /**
     * @param mixed $card_brand
     */
    public function setCardBrand($card_brand)
    {
        $this->card_brand = $card_brand;
    }




}