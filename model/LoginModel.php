<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 28/01/2019
 * Time: 20:46
 */
require_once 'autoloadClass.php';
$autoload = new autoloadClass();
class LoginModel extends CRUD
{

    private $cpf;
    private $senha;

    protected $paramSenha;
    protected $tableUs = '';
    protected $tableSenha = 'senha';

    public function login($cpf,$senha)
    {
        $this->setCpf($cpf);
        $this->setSenha($senha);

        if ($this->CPFexists($cpf)){
            $userAtual = $this->CPFexists($cpf);
            if ($this->VerificarSenha($userAtual->id,$this->paramSenha, $senha)){
                session_start();
                $_SESSION['isLogado'] = true;
                $_SESSION['user_id'] = $userAtual->id;
                $_SESSION['user_type'] = $this->tableUs;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function CPFexists($cpf){
        $usuario = new Usuario();
        if ($usuario->selectCPF($cpf)){
            $this->tableUs = 'usuario';
            $this->paramSenha = 'usuario_id';
            return $usuario->selectCPF($cpf);
        }else{
            $administrador = new Administrador();
            if ($administrador->selectCPF($cpf)){
                $this->tableUs = 'administrador';
                $this->paramSenha = 'administrador_id';
                return $administrador->selectCPF($cpf);
            }else{
                return false;
            }
        }
    }

    protected function VerificarSenha($id, $param, $senha){
        $sql = "SELECT * FROM $this->tableSenha WHERE $param = :id AND senha = :senha";
        $stmt = Conecta::prepare($sql);
        $stmt->bindParam(':id', $id ,PDO::PARAM_INT);
        $stmt->bindParam(':senha', $senha ,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();

    }

    public function insert()
    {
        // TODO: Implement insert() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
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
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }



}