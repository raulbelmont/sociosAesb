<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 24/01/2019
 * Time: 19:19
 */
require_once 'CRUD.php';
class Usuario extends CRUD
{

    private $id; //bigint
    private $cpf; //int
    private $cep; //int
    private $rua; //varchar
    private $numero; //int
    private $complemento; //varchar
    private $bairro; //varchar
    private $pais; //varchar
    private $estado; //varchar
    private $cidade; //varchar
    private $ddd_residencial; //int
    private $telefone_residencial; //int
    private $ddd_celular; //int
    private $telefone_celular; //int
    private $email; //varchar
    private $data_nascimento; //datetime
    private $nome; //varchar
    private $sobrenome; //varchar
    private $data_cadastro; //datetime
    private $ip_acesso; //int
    private $ativo; //tinyint(4)
    private $cartao_credito_id; //bigint
    private $plano_id; //bigint
    private $pgto_adesao_id; //bigint
    private $tipo; //int

    protected $table = 'usuario';

    public function insert()
    {
        $sql = "INSERT INTO $this->table (cpf, cep, rua, numero, complemento, bairro, pais, estado, cidade, ddd_residencial, telefone_residencial,
        ddd_celular, telefone_celular, email, data_nascimento, nome, sobrenome, data_cadastro, ip_acesso, ativo, cartao_credito_id, plano_id, pgto_adesao_id, tipo)
        VALUES (:cpf, :cep, :rua, :numero, :complemento, :bairro, :pais, :estado, :cidade, :ddd_residencial, :telefone_residencial,
        :ddd_celular, :telefone_celular, :email, :data_nascimento, :nome, :sobrenome, :data_cadastro, :ip_acesso, :ativo, :cartao_credito_id, :plano_id, :pgto_adesao_id, :tipo)";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':cep', $this->cep, PDO::PARAM_INT);
        $stmt->bindParam(':rua', $this->rua, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $this->numero, PDO::PARAM_INT);
        $stmt->bindParam(':complemento', $this->complemento, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $this->bairro, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
        $stmt->bindParam(':ddd_residencial', $this->ddd_residencial, PDO::PARAM_INT);
        $stmt->bindParam(':telefone_residencial', $this->telefone_residencial, PDO::PARAM_INT);
        $stmt->bindParam(':ddd_celular', $this->ddd_celular, PDO::PARAM_INT);
        $stmt->bindParam(':telefone_celular', $this->telefone_celular, PDO::PARAM_INT);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $this->data_nascimento, PDO::PARAM_STR);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $this->sobrenome, PDO::PARAM_STR);
        $stmt->bindParam(':data_cadastro', $this->data_cadastro, PDO::PARAM_STR);
        $stmt->bindParam(':ip_acesso', $this->ip_acesso, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $this->ativo, PDO::PARAM_BOOL);
        $stmt->bindParam(':cartao_credito_id', $this->cartao_credito_id, PDO::PARAM_INT);
        $stmt->bindParam(':plano_id', $this->plano_id, PDO::PARAM_INT);
        $stmt->bindParam(':pgto_adesao_id', $this->pgto_adesao_id, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET cpf = :cpf, cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, pais = :pais,
        estado = :estado, cidade = :cidade, ddd_residencial = :ddd_residencial, telefone_residencial = :telefone_residencial, ddd_celular = :ddd_celular,
        telefone_celular = :telefone_celular, email = :email, data_nascimento = :data_nascimento, nome = :nome, sobrenome = :sobrenome,
        data_cadastro = :data_cadastro, ip_acesso = :ip_acesso, ativo = :ativo, cartao_credito_id = :cartao_credito_id, plano_id = :plano_id,
        pgto_adesao_id = :pgto_adesao_id, tipo = :tipo WHERE id = :id";
        $stmt = Conecta::prepare($sql);
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':cep', $this->cep, PDO::PARAM_INT);
        $stmt->bindParam(':rua', $this->rua, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $this->numero, PDO::PARAM_INT);
        $stmt->bindParam(':complemento', $this->complemento, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $this->bairro, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
        $stmt->bindParam(':ddd_residencial', $this->ddd_residencial, PDO::PARAM_INT);
        $stmt->bindParam(':telefone_residencial', $this->telefone_residencial, PDO::PARAM_INT);
        $stmt->bindParam(':ddd_celular', $this->ddd_celular, PDO::PARAM_INT);
        $stmt->bindParam(':telefone_celular', $this->telefone_celular, PDO::PARAM_INT);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $this->data_nascimento, PDO::PARAM_STR);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $this->sobrenome, PDO::PARAM_STR);
        $stmt->bindParam(':data_cadastro', $this->data_cadastro, PDO::PARAM_STR);
        $stmt->bindParam(':ip_acesso', $this->ip_acesso, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $this->ativo, PDO::PARAM_BOOL);
        $stmt->bindParam(':cartao_credito_id', $this->cartao_credito_id, PDO::PARAM_INT);
        $stmt->bindParam(':plano_id', $this->plano_id, PDO::PARAM_INT);
        $stmt->bindParam(':pgto_adesao_id', $this->pgto_adesao_id, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /*buscar por CPF e senha*/
    public function selectCPF($cpf){
        $sql = "SELECT * FROM $this->table WHERE cpf = :cpf";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':cpf',$cpf,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /*Recuperar senha*/
    public function recuperarSenha($cpf,$email){
        $sql = "SELECT * FROM $this->table WHERE cpf = :cpf and email = :email";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':cpf', $cpf , PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getRua()
    {
        return $this->rua;
    }

    /**
     * @param mixed $rua
     */
    public function setRua($rua)
    {
        $this->rua = $rua;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getDddResidencial()
    {
        return $this->ddd_residencial;
    }

    /**
     * @param mixed $ddd_residencial
     */
    public function setDddResidencial($ddd_residencial)
    {
        $this->ddd_residencial = $ddd_residencial;
    }

    /**
     * @return mixed
     */
    public function getTelefoneResidencial()
    {
        return $this->telefone_residencial;
    }

    /**
     * @param mixed $telefone_residencial
     */
    public function setTelefoneResidencial($telefone_residencial)
    {
        $this->telefone_residencial = $telefone_residencial;
    }

    /**
     * @return mixed
     */
    public function getDddCelular()
    {
        return $this->ddd_celular;
    }

    /**
     * @param mixed $ddd_celular
     */
    public function setDddCelular($ddd_celular)
    {
        $this->ddd_celular = $ddd_celular;
    }

    /**
     * @return mixed
     */
    public function getTelefoneCelular()
    {
        return $this->telefone_celular;
    }

    /**
     * @param mixed $telefone_celular
     */
    public function setTelefoneCelular($telefone_celular)
    {
        $this->telefone_celular = $telefone_celular;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    /**
     * @param mixed $data_nascimento
     */
    public function setDataNascimento($data_nascimento)
    {
        $this->data_nascimento = $data_nascimento;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * @param mixed $sobrenome
     */
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    /**
     * @return mixed
     */
    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }

    /**
     * @param mixed $data_cadastro
     */
    public function setDataCadastro($data_cadastro)
    {
        $this->data_cadastro = $data_cadastro;
    }

    /**
     * @return mixed
     */
    public function getIpAcesso()
    {
        return $this->ip_acesso;
    }

    /**
     * @param mixed $ip_acesso
     */
    public function setIpAcesso($ip_acesso)
    {
        $this->ip_acesso = $ip_acesso;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return mixed
     */
    public function getCartaoCreditoId()
    {
        return $this->cartao_credito_id;
    }

    /**
     * @param mixed $cartao_credito_id
     */
    public function setCartaoCreditoId($cartao_credito_id)
    {
        $this->cartao_credito_id = $cartao_credito_id;
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

    /**
     * @return mixed
     */
    public function getPgtoAdesaoId()
    {
        return $this->pgto_adesao_id;
    }

    /**
     * @param mixed $pgto_adesao_id
     */
    public function setPgtoAdesaoId($pgto_adesao_id)
    {
        $this->pgto_adesao_id = $pgto_adesao_id;
    }



    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }





}


