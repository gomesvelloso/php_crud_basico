<?php
/*
* Classe responável pelos dedos dos usuários. 
* Ela herda da classe Conexão.
* @since 2021-08-01
* @author Dennis Henrique
*/
require_once("Conexao.php");

class Usuario extends Conexao
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tabela = 'usuarios';


    public function getId(){
        return $this->id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getSenha(){
        return $this->senha;
    }

    public function setId(int $id){
        $this->id = $id;
    }
    public function setNome(string $nome){
        $this->nome = $nome;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }
    public function setSenha(string $senha){
        $this->senha = $senha;
    }
    
    public function criar(){
        
        $sql = "INSERT INTO usuarios (nome, senha, email) VALUES ('$this->nome', MD5('$this->senha'), '$this->email');";
        $res = mysqli_query(parent::getConexao(), $sql) or die(mysqli_error(parent::getConexao()));
        return mysqli_insert_id(parent::getConexao());
    }

    public function login(){
        $sql = "SELECT * FROM $this->tabela WHERE email = '$this->email' AND senha = MD5('$this->senha') LIMIT 1";
        $res = mysqli_query(parent::getConexao(), $sql) or die(mysqli_error(parent::getConexao()));
        
        if(mysqli_num_rows($res)){
            $row = mysqli_fetch_object($res);
            $obj = new Usuario();
            $obj->setId($row->id);
            $obj->setNome($row->nome);
            $obj->setSenha($row->senha);
            $obj->setEmail($row->email);
        }else{
            $obj = null;
        }
        return $obj;
    }

    public function listar($params=array()){
        $aux_where = null;
        
        if(isset($params["pesquisa"])){
            $pesquisa = $params["pesquisa"];
            unset($params["pesquisa"]);
            if($pesquisa != ""){
                $aux_where.= " AND (email like '%$pesquisa%' OR nome like '%$pesquisa%') ";
            }
        }
        
        $lista = array();
        if(!empty($params)){
            foreach($params as $coluna =>$valor){
                $aux_where .= " AND $coluna = '{$valor}' ";
            }
        }
        
        $sql = "SELECT * FROM $this->tabela WHERE id > 0 $aux_where";
        $res = mysqli_query(parent::getConexao(), $sql) or die(mysqli_error(parent::getConexao()));
        while($row = mysqli_fetch_object($res)){
            $obj = new Usuario();
            $obj->setId($row->id);
            $obj->setNome($row->nome);
            $obj->setSenha($row->senha);
            $obj->setEmail($row->email);
            array_push($lista, $obj);
        }
        return $lista;
    }

    public function apagar(int $id){
        $sql = "DELETE FROM $this->tabela WHERE id ='$id' LIMIT 1";
        $res = mysqli_query(parent::getConexao(), $sql) or die(mysqli_error(parent::getConexao()));
    }

    public function ataualizar(){
        $sql = "UPDATE 
                    $this->tabela 
                SET
                    nome  = '{$this->nome}',
                    email = '{$this->email}'
                WHERE
                    id = '{$this->id}'
                LIMIT 1
                ";
        $res = mysqli_query(parent::getConexao(), $sql) or die(mysqli_error(parent::getConexao()));
    }

    public function alterarSenha(int $id, string $senha){
        $sql = "UPDATE 
                    $this->tabela 
                SET
                    senha  = MD5('$senha')
                WHERE
                    id = '{$id}'
                LIMIT 1
                ";
        $res = mysqli_query(parent::getConexao(), $sql) or die(mysqli_error(parent::getConexao()));
    }
    
}

?>